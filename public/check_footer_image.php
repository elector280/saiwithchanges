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
$appUrl = rtrim($env['APP_URL'] ?? 'https://sai.ngo', '/');

echo "<style>body{font-family:monospace;font-size:13px;} .ok{color:green;} .bad{color:red;} img{max-width:150px;border:2px solid green;margin:5px;}</style>";
echo "<h2>Venezuela Story Footer Image Check</h2>";

$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$storagePath = __DIR__ . '/storage/story_image';

// Find the Venezuela story
$stmt = $pdo->prepare("SELECT id, image, footer_image2, header_photo FROM stories WHERE slug LIKE ? LIMIT 1");
$stmt->execute(['%financial-crisis-in-venezuela%']);
$story = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$story) {
    // Try broader search
    $stmt2 = $pdo->prepare("SELECT id, image, footer_image2, header_photo, slug FROM stories WHERE JSON_EXTRACT(slug, '$.en') LIKE ? LIMIT 1");
    $stmt2->execute(['%venezuela%']);
    $story = $stmt2->fetch(PDO::FETCH_ASSOC);
}

if ($story) {
    echo "<p>Story ID: <strong>{$story['id']}</strong></p>";

    foreach (['image', 'footer_image2', 'header_photo'] as $field) {
        $val = $story[$field] ?? '';
        echo "<h3>Field: $field</h3>";
        echo "<p>Value: <strong>" . ($val ?: 'EMPTY') . "</strong></p>";

        if ($val) {
            $filename = basename($val);
            $filePath = $storagePath . '/' . $filename;
            $exists = file_exists($filePath);
            $class = $exists ? 'ok' : 'bad';
            echo "<p class='$class'>File on disk: $filePath → " . ($exists ? "EXISTS ✓" : "MISSING ✗") . "</p>";

            $url = $appUrl . '/storage/story_image/' . $filename;
            echo "<p>URL: <a href='$url' target='_blank'>$url</a></p>";
            echo "<img src='$url' onerror=\"this.style.border='2px solid red'; this.alt='BROKEN'\" alt='test'>";
        }
    }
} else {
    echo "<p class='bad'>Story not found! Showing all stories with slugs:</p>";
    $all = $pdo->query("SELECT id, JSON_EXTRACT(slug,'$.en') as slug_en, image, footer_image2 FROM stories LIMIT 20")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($all as $s) {
        echo "<p>ID {$s['id']}: {$s['slug_en']} — image={$s['image']}, footer2={$s['footer_image2']}</p>";
    }
}

echo "<hr><strong>Done!</strong>";
?>
