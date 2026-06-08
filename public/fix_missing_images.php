<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Read .env manually
$envFile = __DIR__ . '/../.env';
$env = [];
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            [$key, $val] = explode('=', $line, 2);
            $env[trim($key)] = trim($val, " \t\n\r\0\x0B\"'");
        }
    }
}

$host   = $env['DB_HOST']     ?? '127.0.0.1';
$dbname = $env['DB_DATABASE'] ?? '';
$user   = $env['DB_USERNAME'] ?? '';
$pass   = $env['DB_PASSWORD'] ?? '';

echo "<style>body{font-family:monospace;font-size:13px;} .ok{color:green;} .bad{color:red;} .warn{color:orange;}</style>";
echo "<h2>Fix Missing Story Images</h2>";

$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$storagePath = __DIR__ . '/storage/story_image';

// Get all stories that have footer_image2 or image set
$stories = $pdo->query("SELECT id, image, footer_image2, header_photo FROM stories")->fetchAll(PDO::FETCH_ASSOC);

$fixed = 0;

foreach ($stories as $story) {
    $updates = [];

    // Check footer_image2
    if (!empty($story['footer_image2'])) {
        $filename = basename($story['footer_image2']);
        $filePath = $storagePath . '/' . $filename;
        if (!file_exists($filePath)) {
            echo "<p class='bad'>Story ID {$story['id']}: footer_image2 '{$story['footer_image2']}' is MISSING → clearing it</p>";
            $updates['footer_image2'] = null;
        }
    }

    // Check image
    if (!empty($story['image'])) {
        $filename = basename($story['image']);
        $filePath = $storagePath . '/' . $filename;
        if (!file_exists($filePath)) {
            echo "<p class='bad'>Story ID {$story['id']}: image '{$story['image']}' is MISSING → clearing it</p>";
            $updates['image'] = null;
        }
    }

    // Check header_photo
    if (!empty($story['header_photo'])) {
        $filename = basename($story['header_photo']);
        $filePath = $storagePath . '/' . $filename;
        if (!file_exists($filePath)) {
            echo "<p class='bad'>Story ID {$story['id']}: header_photo '{$story['header_photo']}' is MISSING → clearing it</p>";
            $updates['header_photo'] = null;
        }
    }

    if (!empty($updates)) {
        $setClauses = [];
        foreach ($updates as $col => $val) {
            $setClauses[] = "$col = " . ($val === null ? "NULL" : $pdo->quote($val));
        }
        $sql = "UPDATE stories SET " . implode(', ', $setClauses) . " WHERE id = " . $story['id'];
        $pdo->exec($sql);
        $fixed++;
    }
}

if ($fixed === 0) {
    echo "<p class='ok'>✓ All story image fields point to existing files. Nothing to fix!</p>";
} else {
    echo "<p class='ok'><strong>Fixed $fixed stories with missing image references.</strong></p>";
    echo "<p>The stories will now show their fallback images correctly.</p>";
}

echo "<hr><strong>Done! Please clear Laravel cache and refresh the page.</strong>";
?>
