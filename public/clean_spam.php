<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Cleaning SEO Spam...<br>";

$settings = DB::table('settings')->first();
if ($settings) {
    $tagManager = $settings->tag_manager ?? '';
    $gtmBody = $settings->google_tag_manager_body ?? '';

    // Regex to remove hidden divs (typical SEO spam)
    $pattern = '/<div[^>]*style=["\'][^"\']*(?:position:\s*absolute|display:\s*none|left:\s*-[0-9]+px)[^"\']*["\'][^>]*>.*?<\/div>/is';
    
    // Also remove any link tags pointing to gambling/casino sites
    $patternLinks = '/<a[^>]*href=["\'][^"\']*(?:casino|slot|bet|judi|gacor)[^"\']*["\'][^>]*>.*?<\/a>/is';
    
    $cleanTagManager = preg_replace($pattern, '', $tagManager);
    $cleanTagManager = preg_replace($patternLinks, '', $cleanTagManager);

    $cleanGtmBody = preg_replace($pattern, '', $gtmBody);
    $cleanGtmBody = preg_replace($patternLinks, '', $cleanGtmBody);

    if ($tagManager !== $cleanTagManager || $gtmBody !== $cleanGtmBody) {
        DB::table('settings')->where('id', $settings->id)->update([
            'tag_manager' => $cleanTagManager,
            'google_tag_manager_body' => $cleanGtmBody
        ]);
        echo "Spam removed from tag_manager/google_tag_manager_body.<br>";
    } else {
        echo "No spam matched the regex in tag_manager.<br>";
    }

    // Update dates in all string columns of settings
    $columns = DB::getSchemaBuilder()->getColumnListing('settings');
    $updates = [];
    foreach ($columns as $col) {
        $val = $settings->$col;
        if (is_string($val)) {
            $newVal = str_replace(['2024', '2025'], '2026', $val);
            if ($newVal !== $val) {
                $updates[$col] = $newVal;
            }
        }
    }
    
    if (!empty($updates)) {
        DB::table('settings')->where('id', $settings->id)->update($updates);
        echo "Dates updated in settings table for columns: " . implode(', ', array_keys($updates)) . "<br>";
    } else {
        echo "No 2024/2025 dates found in settings.<br>";
    }
}

// Update dates in other tables
$tablesToCheck = ['campaigns', 'blogs', 'pages'];
foreach ($tablesToCheck as $table) {
    if (DB::getSchemaBuilder()->hasTable($table)) {
        $records = DB::table($table)->get();
        $cols = DB::getSchemaBuilder()->getColumnListing($table);
        $updatedCount = 0;
        foreach ($records as $record) {
            $updateRec = [];
            foreach ($cols as $col) {
                $val = $record->$col;
                if (is_string($val)) {
                    $newVal = str_replace(['2024', '2025'], '2026', $val);
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
            echo "Updated dates in $updatedCount records in table $table.<br>";
        }
    }
}

echo "Done.<br>";
