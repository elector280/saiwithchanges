<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

ini_set('display_errors', 1);
error_reporting(E_ALL);
set_time_limit(60);

echo "<style>body{font-family:monospace;font-size:13px;} .ok{color:green;} .bad{color:red;} .warn{color:orange;}</style>";
echo "<h2>Image Diagnostics</h2>";

// Check storage path
$storagePath = public_path('storage');
echo "<p>Storage path: <strong>$storagePath</strong> - ";
echo is_dir($storagePath) ? "<span class='ok'>EXISTS</span>" : "<span class='bad'>MISSING!</span>";
echo "</p>";

// Check story_image folder
$storyImagePath = $storagePath . '/story_image';
echo "<p>story_image folder: <strong>$storyImagePath</strong> - ";
echo is_dir($storyImagePath) ? "<span class='ok'>EXISTS</span>" : "<span class='bad'>MISSING!</span>";
echo "</p>";

// Check campaign_cover_image folder
$campaignPath = $storagePath . '/campaign_cover_image';
echo "<p>campaign_cover_image folder: <strong>$campaignPath</strong> - ";
echo is_dir($campaignPath) ? "<span class='ok'>EXISTS</span>" : "<span class='bad'>MISSING!</span>";
echo "</p>";

echo "<hr><h3>Checking stories table images...</h3>";

$stories = DB::table('stories')->select('id', 'image', 'header_photo')->get();
foreach ($stories as $story) {
    $image = $story->image;
    $header = $story->header_photo;

    // Check main image
    if ($image) {
        $clean = ltrim(preg_replace('#^story_image/#', '', $image), '/');
        $fullPath = $storyImagePath . '/' . $clean;
        $exists = file_exists($fullPath);
        $class = $exists ? 'ok' : 'bad';
        echo "<p class='$class'>Story ID {$story->id} - image: <strong>$image</strong> => " . ($exists ? "OK" : "MISSING at $fullPath") . "</p>";
    }

    // Check header photo
    if ($header) {
        $clean = ltrim(preg_replace('#^story_image/#', '', $header), '/');
        $fullPath = $storyImagePath . '/' . $clean;
        $exists = file_exists($fullPath);
        $class = $exists ? 'ok' : 'bad';
        echo "<p class='$class'>Story ID {$story->id} - header_photo: <strong>$header</strong> => " . ($exists ? "OK" : "MISSING at $fullPath") . "</p>";
    }
}

echo "<hr><h3>Checking settings campaign_cover_image...</h3>";
$setting = DB::table('settings')->first();
if ($setting) {
    $cover = $setting->campaign_cover_image ?? null;
    if ($cover) {
        $fullPath = $campaignPath . '/' . $cover;
        $exists = file_exists($fullPath);
        $class = $exists ? 'ok' : 'bad';
        echo "<p class='$class'>campaign_cover_image: <strong>$cover</strong> => " . ($exists ? "OK" : "MISSING at $fullPath") . "</p>";
    } else {
        echo "<p class='warn'>campaign_cover_image is empty in settings!</p>";
    }
    
    $heroImage = $setting->hero_image ?? null;
    if ($heroImage) {
        $heroPath = $storagePath . '/hero_image/' . $heroImage;
        $exists = file_exists($heroPath);
        $class = $exists ? 'ok' : 'bad';
        echo "<p class='$class'>hero_image: <strong>$heroImage</strong> => " . ($exists ? "OK" : "MISSING at $heroPath") . "</p>";
    }
}

echo "<hr><h3>Files actually in story_image folder:</h3>";
if (is_dir($storyImagePath)) {
    $files = scandir($storyImagePath);
    foreach ($files as $f) {
        if ($f !== '.' && $f !== '..') {
            echo "<p class='ok'>$f</p>";
        }
    }
} else {
    echo "<p class='bad'>Directory does not exist!</p>";
}

echo "<hr><strong>Done!</strong>";
