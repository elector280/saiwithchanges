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

echo "<style>body{font-family:monospace;font-size:13px;} .ok{color:green;} .bad{color:red;} .warn{color:orange;} pre{background:#f5f5f5;padding:10px;}</style>";
echo "<h2>Settings Image Fixer</h2>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p class='ok'>Connected to database: <strong>$dbname</strong></p>";
} catch (Exception $e) {
    echo "<p class='bad'>DB Connection failed: " . $e->getMessage() . "</p>";
    exit;
}

// --- Get storage path ---
$storagePath = dirname(__DIR__) . '/public/storage';
echo "<p>Storage path: $storagePath - ";
echo is_dir($storagePath) ? "<span class='ok'>EXISTS</span>" : "<span class='bad'>MISSING!</span>";
echo "</p>";

// --- Show all tables ---
echo "<h3>All tables in database:</h3><pre>";
$allTables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
foreach ($allTables as $t) echo "- $t\n";
echo "</pre>";

// --- Find the settings table ---
$possibleNames = ['settings', 'site_settings', 'app_settings', 'system_settings', 'options', 'configurations'];
$settingsTable = null;
foreach ($possibleNames as $name) {
    if (in_array($name, $allTables)) {
        $settingsTable = $name;
        break;
    }
}
if (!$settingsTable) {
    echo "<p class='bad'>Could not find settings table! Check table list above.</p>";
    exit;
}
echo "<p class='ok'>Found settings table: <strong>$settingsTable</strong></p>";

// --- Get all settings ---
$stmt = $pdo->query("SELECT * FROM $settingsTable LIMIT 1");
$setting = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$setting) {
    echo "<p class='bad'>No settings row found!</p>";
    exit;
}

echo "<h3>Image fields in settings:</h3><pre>";
$imageFields = [
    'campaign_cover_image' => 'campaign_cover_image',
    'hero_image'           => 'hero_image',
    'logo'                 => 'logo',
    'logo_alt'             => 'logo_alt',
    'favicon'              => 'favicon',
    'bg_image'             => 'bg_image',
    'footer_image'         => 'footer_image',
    'footer_image2'        => 'footer_image2',
    'og_image'             => 'og_image',
];

foreach ($imageFields as $col => $folder) {
    if (!array_key_exists($col, $setting)) continue;
    $val = $setting[$col];
    if (empty($val)) {
        echo "[$col]: EMPTY\n";
        continue;
    }
    $checkPath = $storagePath . '/' . $folder . '/' . $val;
    $exists = file_exists($checkPath);
    echo "[$col]: $val => " . ($exists ? "OK ✓" : "MISSING at $checkPath") . "\n";
}
echo "</pre>";

// --- Check if the help_people_need_image field exists ---
$stmt2 = $pdo->query("SHOW COLUMNS FROM $settingsTable LIKE 'help_people_need_image'");
$col = $stmt2->fetch();
if ($col) {
    $val = $setting['help_people_need_image'] ?? '';
    if ($val) {
        $checkPath = $storagePath . '/help_people_need_image/' . $val;
        $exists = file_exists($checkPath);
        echo "<p>[help_people_need_image]: $val => " . ($exists ? "<span class='ok'>OK</span>" : "<span class='bad'>MISSING at $checkPath</span>") . "</p>";
    }
}

// --- Show files actually in campaign_cover_image ---
echo "<h3>Files in campaign_cover_image folder:</h3><pre>";
$dir = $storagePath . '/campaign_cover_image';
if (is_dir($dir)) {
    foreach (scandir($dir) as $f) {
        if ($f !== '.' && $f !== '..') echo "$f\n";
    }
} else {
    echo "FOLDER MISSING!";
}
echo "</pre>";

// --- Show files actually in help_people_need_image ---
echo "<h3>Files in help_people_need_image folder:</h3><pre>";
$dir2 = $storagePath . '/help_people_need_image';
if (is_dir($dir2)) {
    foreach (scandir($dir2) as $f) {
        if ($f !== '.' && $f !== '..') echo "$f\n";
    }
} else {
    echo "FOLDER MISSING!";
}
echo "</pre>";

echo "<hr><strong>Done!</strong>";
?>
