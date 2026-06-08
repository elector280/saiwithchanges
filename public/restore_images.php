<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "<h2>Restoring and Fixing Image Paths...</h2>";

function findOriginalImage($brokenFileName) {
    // If the file has 2026, let's try to find 2024 or 2025
    $baseName2024 = str_replace('2026', '2024', basename($brokenFileName));
    $baseName2025 = str_replace('2026', '2025', basename($brokenFileName));
    
    // We will recursively search public/storage for these files
    $directory = new RecursiveDirectoryIterator(public_path('storage'));
    $iterator = new RecursiveIteratorIterator($directory);
    
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            if ($file->getFilename() === $baseName2024 || $file->getFilename() === $baseName2025) {
                // Return the filename that actually exists
                return str_replace('2026', strpos($file->getFilename(), '2024') !== false ? '2024' : '2025', $brokenFileName);
            }
        }
    }
    
    // Fallback: just return 2024 version
    return str_replace('2026', '2024', $brokenFileName);
}

function fixString($val) {
    if (!is_string($val)) return $val;
    if (strpos($val, '2026') === false) return $val;

    // Fix raw image filenames
    if (preg_match('/^[^<>\n]*2026[^<>\n]*\.(jpg|jpeg|png|gif|webp|svg|pdf)$/i', $val)) {
        return findOriginalImage($val);
    }

    // Fix images in HTML attributes
    $val = preg_replace_callback('/(["\'])([^"\']*?2026[^"\']*?\.(?:jpg|jpeg|png|gif|webp|svg|pdf))\1/i', function($matches) {
        $quote = $matches[1];
        $path = $matches[2];
        $fixedPath = findOriginalImage($path);
        return $quote . $fixedPath . $quote; 
    }, $val);

    return $val;
}

// Get ALL tables dynamically to ensure we don't miss 'stories' or others
$tablesToCheck = DB::connection()->getDoctrineSchemaManager()->listTableNames();

foreach ($tablesToCheck as $table) {
    try {
        $records = DB::table($table)->get();
        $cols = DB::getSchemaBuilder()->getColumnListing($table);
        $updatedCount = 0;
        foreach ($records as $record) {
            $updateRec = [];
            foreach ($cols as $col) {
                if (isset($record->$col)) {
                    $val = $record->$col;
                    if (is_string($val) && strpos($val, '2026') !== false) {
                        $newVal = fixString($val);
                        if ($newVal !== $val) {
                            $updateRec[$col] = $newVal;
                        }
                    }
                }
            }
            if (!empty($updateRec)) {
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
