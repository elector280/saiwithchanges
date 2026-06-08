<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<style>body{font-family:monospace;font-size:13px;} .ok{color:green;} .bad{color:red;} .warn{color:orange;}</style>";
echo "<h2>Storage Structure Diagnostic</h2>";

// Paths to check
$publicStoragePath  = __DIR__ . '/storage';            // public/storage
$appStoragePath     = dirname(__DIR__) . '/storage/app/public'; // storage/app/public

echo "<h3>1. public/storage/ path:</h3>";
echo "<p>Path: <strong>$publicStoragePath</strong></p>";

if (is_link($publicStoragePath)) {
    $target = readlink($publicStoragePath);
    echo "<p class='ok'>✓ This is a SYMLINK pointing to: <strong>$target</strong></p>";
} elseif (is_dir($publicStoragePath)) {
    echo "<p class='warn'>⚠️ This is a REAL DIRECTORY (not a symlink!)</p>";
    echo "<p class='bad'>This means Storage::disk('public') will NOT find files here!</p>";
} else {
    echo "<p class='bad'>❌ Does not exist at all!</p>";
}

echo "<h3>2. storage/app/public/ path:</h3>";
echo "<p>Path: <strong>$appStoragePath</strong></p>";
if (is_dir($appStoragePath)) {
    echo "<p class='ok'>✓ EXISTS</p>";
    // Count files in story_image
    $storyImageDir = $appStoragePath . '/story_image';
    if (is_dir($storyImageDir)) {
        $count = count(array_diff(scandir($storyImageDir), ['.', '..']));
        echo "<p class='ok'>story_image/ has <strong>$count files</strong></p>";
    } else {
        echo "<p class='bad'>story_image/ folder MISSING in storage/app/public!</p>";
    }
} else {
    echo "<p class='bad'>❌ Does not exist!</p>";
}

echo "<h3>3. Files in public/storage/story_image/:</h3>";
$dir = $publicStoragePath . '/story_image';
if (is_dir($dir)) {
    $files = array_diff(scandir($dir), ['.', '..']);
    echo "<p class='ok'>" . count($files) . " files found</p>";
    echo "<pre>" . implode("\n", array_slice($files, 0, 10)) . "\n..." . "</pre>";
} else {
    echo "<p class='bad'>Folder missing!</p>";
}

echo "<h3>4. Files in storage/app/public/story_image/:</h3>";
$dir2 = $appStoragePath . '/story_image';
if (is_dir($dir2)) {
    $files2 = array_diff(scandir($dir2), ['.', '..']);
    echo "<p>" . count($files2) . " files found</p>";
    echo "<pre>" . implode("\n", array_slice($files2, 0, 10)) . "\n..." . "</pre>";
} else {
    echo "<p class='bad'>Folder missing! Storage::disk('public') will fail for images.</p>";
}

echo "<hr><h3>Conclusion & Fix:</h3>";
if (is_link($publicStoragePath)) {
    echo "<p class='ok'>✓ Symlink is correct. File serving through controller should work.</p>";
} else {
    echo "<p class='bad'>❌ <strong>public/storage is NOT a symlink!</strong> This is the root cause.</p>";
    echo "<p>The story images are in <code>public/storage/story_image/</code> but the controller looks in <code>storage/app/public/story_image/</code>.</p>";
    echo "<p><strong>Fix:</strong> Run <code>php artisan storage:link</code> via SSH, OR manually copy files from <code>public/storage/</code> to <code>storage/app/public/</code>.</p>";
    
    // Generate artisan command suggestion
    echo "<p>Or upload the file below and visit: <code>https://sai.ngo/create_storage_link.php</code></p>";
}

echo "<hr><strong>Done!</strong>";
?>
