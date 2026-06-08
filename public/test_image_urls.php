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

echo "<style>body{font-family:monospace;font-size:13px;} .ok{color:green;} .bad{color:red;} .warn{color:orange;} pre{background:#f5f5f5;padding:10px;} img{max-width:200px;border:2px solid green;margin:5px;}</style>";
echo "<h2>Image URL Tester</h2>";

$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$storagePath = __DIR__ . '/storage';

function testUrl($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    curl_close($ch);
    return ['code' => $code, 'url' => $finalUrl];
}

// --- Find Venezuela story ---
echo "<h3>Venezuela story image test:</h3>";
$slug = 'financial-crisis-in-venezuela-the-search-for-solutions-to-alleviate-poverty';
$stmt = $pdo->query("SELECT id, image, header_photo, slug FROM stories WHERE slug LIKE '%" . $slug . "%' LIMIT 1");
$story = $stmt->fetch(PDO::FETCH_ASSOC);

if ($story) {
    echo "<p>Story ID: <strong>{$story['id']}</strong></p>";
    echo "<p>image field: <strong>" . ($story['image'] ?: 'EMPTY') . "</strong></p>";
    echo "<p>header_photo field: <strong>" . ($story['header_photo'] ?: 'EMPTY') . "</strong></p>";

    // Test header_photo URL
    if ($story['header_photo']) {
        $url = $appUrl . '/storage/story_image/' . $story['header_photo'];
        $result = testUrl($url);
        $class = $result['code'] == 200 ? 'ok' : 'bad';
        echo "<p class='$class'>header_photo URL: <a href='$url' target='_blank'>$url</a> → HTTP {$result['code']}</p>";
        if ($result['code'] == 200) {
            echo "<img src='$url'>";
        }
    }

    // Test image URL via direct asset
    if ($story['image']) {
        $imgFile = ltrim(preg_replace('#^story_image/#', '', $story['image']), '/');
        $url = $appUrl . '/storage/story_image/' . $imgFile;
        $result = testUrl($url);
        $class = $result['code'] == 200 ? 'ok' : 'bad';
        echo "<p class='$class'>image URL: <a href='$url' target='_blank'>$url</a> → HTTP {$result['code']}</p>";
        if ($result['code'] == 200) {
            echo "<img src='$url'>";
        }
    }
} else {
    echo "<p class='warn'>Venezuela story not found by slug. Showing all stories with images:</p>";
    $all = $pdo->query("SELECT id, image, header_photo FROM stories WHERE header_photo IS NOT NULL OR image IS NOT NULL LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($all as $s) {
        echo "<p>ID {$s['id']}: image={$s['image']}, header={$s['header_photo']}</p>";
    }
}

// --- Test campaign_cover_image ---
echo "<hr><h3>Help People Need banner image test:</h3>";
$ws = $pdo->query("SELECT campaign_cover_image, help_people_need_image FROM website_settings LIMIT 1")->fetch(PDO::FETCH_ASSOC);
if ($ws) {
    foreach (['campaign_cover_image', 'help_people_need_image'] as $field) {
        $val = $ws[$field] ?? '';
        if ($val) {
            $folder = $field;
            $url = $appUrl . '/storage/' . $folder . '/' . $val;
            $result = testUrl($url);
            $class = $result['code'] == 200 ? 'ok' : 'bad';
            echo "<p class='$class'>$field: <a href='$url' target='_blank'>$url</a> → HTTP {$result['code']}</p>";
            if ($result['code'] == 200) {
                echo "<img src='$url'>";
            }
        }
    }
}

echo "<hr><h3>Check what the template uses for the banner:</h3>";
echo "<p>The help_people_need_section.blade.php uses <strong>campaign_cover_image</strong> field.</p>";
echo "<p>URL generated: <strong>$appUrl/storage/campaign_cover_image/" . ($ws['campaign_cover_image'] ?? 'EMPTY') . "</strong></p>";
echo "<img src='$appUrl/storage/campaign_cover_image/" . ($ws['campaign_cover_image'] ?? '') . "' onerror=\"this.style.border='2px solid red'; this.alt='BROKEN'\">";

echo "<hr><strong>Done!</strong>";
?>
