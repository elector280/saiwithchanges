<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Restoring image paths...<br>";

function fixString($val) {
    if (!is_string($val)) return $val;
    if (strpos($val, '2026') === false) return $val;

    // Fix raw image filenames
    if (preg_match('/^[^<>\n]*2026[^<>\n]*\.(jpg|jpeg|png|gif|webp|svg|pdf)$/i', $val)) {
        $test2024 = str_replace('2026', '2024', $val);
        $test2025 = str_replace('2026', '2025', $val);
        
        $baseDirs = [
            public_path(),
            public_path('storage/hero_image'),
            public_path('storage/logo'),
            public_path('storage/gallery_image'),
            public_path('storage'),
            public_path('images')
        ];
        
        foreach ([$test2024, $test2025] as $candidate) {
            foreach ($baseDirs as $dir) {
                if (file_exists($dir . '/' . basename($candidate)) || file_exists($dir . '/' . $candidate) || file_exists(public_path($candidate))) {
                    return $candidate;
                }
            }
        }
        return $test2024;
    }

    // Fix images in HTML attributes
    $val = preg_replace_callback('/(["\'])([^"\']*?2026[^"\']*?\.(?:jpg|jpeg|png|gif|webp|svg|pdf))\1/i', function($matches) {
        $quote = $matches[1];
        $path = $matches[2];
        $test2024 = str_replace('2026', '2024', $path);
        $test2025 = str_replace('2026', '2025', $path);
        
        foreach ([$test2024, $test2025] as $candidate) {
             if (file_exists(public_path(ltrim(parse_url($candidate, PHP_URL_PATH), '/')))) {
                 return $quote . $candidate . $quote;
             }
        }
        return $quote . $test2024 . $quote; 
    }, $val);

    return $val;
}

$tablesToCheck = ['settings', 'campaigns', 'blogs', 'pages'];
foreach ($tablesToCheck as $table) {
    if (DB::getSchemaBuilder()->hasTable($table)) {
        $records = DB::table($table)->get();
        $cols = DB::getSchemaBuilder()->getColumnListing($table);
        $updatedCount = 0;
        foreach ($records as $record) {
            $updateRec = [];
            foreach ($cols as $col) {
                $val = $record->$col;
                if (is_string($val) && strpos($val, '2026') !== false) {
                    $newVal = fixString($val);
                    if ($newVal !== $val) {
                        $updateRec[$col] = $newVal;
                    }
                }
            }
            if (!empty($updateRec)) {
                DB::table($table)->where('id', $record->id)->update($updateRec);
                $updatedCount++;
            }
        }
        if ($updatedCount > 0) {
            echo "Restored image paths in $updatedCount records in table $table.<br>";
        }
    }
}

echo "Done.<br>";
