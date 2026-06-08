<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Show errors so the user can see what happens if it crashes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
set_time_limit(300); // Allow 5 minutes

echo "<h2>Restoring and Fixing Image Paths...</h2>";

// Pre-load all files from public/storage to avoid scanning directory in a loop
$storagePath = public_path('storage');
$allFiles = [];
if (is_dir($storagePath)) {
    $directory = new RecursiveDirectoryIterator($storagePath);
    $iterator = new RecursiveIteratorIterator($directory);
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $allFiles[$file->getFilename()] = true;
        }
    }
}

function findOriginalImage($brokenFileName, $allFiles) {
    $baseName2024 = str_replace('2026', '2024', basename($brokenFileName));
    $baseName2025 = str_replace('2026', '2025', basename($brokenFileName));
    
    if (isset($allFiles[$baseName2024])) {
        return str_replace('2026', '2024', $brokenFileName);
    }
    if (isset($allFiles[$baseName2025])) {
        return str_replace('2026', '2025', $brokenFileName);
    }
    
    // Fallback: just return 2024
    return str_replace('2026', '2024', $brokenFileName);
}

function fixString($val, $allFiles) {
    if (!is_string($val)) return $val;
    if (strpos($val, '2026') === false) return $val;

    // Fix raw image filenames
    if (preg_match('/^[^<>\n]*2026[^<>\n]*\.(jpg|jpeg|png|gif|webp|svg|pdf)$/i', $val)) {
        return findOriginalImage($val, $allFiles);
    }

    // Fix images in HTML attributes
    $val = preg_replace_callback('/(["\'])([^"\']*?2026[^"\']*?\.(?:jpg|jpeg|png|gif|webp|svg|pdf))\1/i', function($matches) use ($allFiles) {
        $quote = $matches[1];
        $path = $matches[2];
        $fixedPath = findOriginalImage($path, $allFiles);
        return $quote . $fixedPath . $quote; 
    }, $val);

    return $val;
}

// Get ALL tables using raw SQL to avoid dbal dependency
$tables = DB::select('SHOW TABLES');
$databaseName = DB::connection()->getDatabaseName();
$tableKey = 'Tables_in_' . $databaseName;

foreach ($tables as $tableObj) {
    // Handling different possible key names in the returned object
    $tableArray = (array) $tableObj;
    $table = array_values($tableArray)[0];
    
    try {
        $records = DB::table($table)->get();
        if ($records->isEmpty()) continue;
        
        // Get columns from the first record
        $cols = array_keys((array)$records->first());
        $updatedCount = 0;
        
        foreach ($records as $record) {
            $updateRec = [];
            foreach ($cols as $col) {
                if (isset($record->$col)) {
                    $val = $record->$col;
                    if (is_string($val) && strpos($val, '2026') !== false) {
                        $newVal = fixString($val, $allFiles);
                        if ($newVal !== $val) {
                            $updateRec[$col] = $newVal;
                        }
                    }
                }
            }
            if (!empty($updateRec) && isset($record->id)) {
                DB::table($table)->where('id', $record->id)->update($updateRec);
                $updatedCount++;
            }
        }
        if ($updatedCount > 0) {
            echo "Restored image paths in <strong>$updatedCount</strong> records in table <strong>$table</strong>.<br>";
        }
    } catch (\Exception $e) {
        // Skip tables without 'id' column or other issues
        continue;
    }
}

echo "<br><strong>Done!</strong> Please refresh your website.";
