<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

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

$pdo = new PDO("mysql:host={$env['DB_HOST']};dbname={$env['DB_DATABASE']};charset=utf8", $env['DB_USERNAME'], $env['DB_PASSWORD']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "<style>body{font-family:monospace;font-size:13px;} .ok{color:green;} .bad{color:red;}</style>";
echo "<h2>Restoring Stats & Content Fields</h2>";

// Hardcoded values extracted from the saingo_sai_ngo.sql backup
$updates = [
    'peaple_helped' => '30k+',
    'volunteers' => '230',
    'educated_children' => '365',
    'service_meal' => '250k',
    'help_people_need_content' => '{"en":"Start Donating Today, \r\nMake the Difference","es":"Empieza a donar hoy mismo. \r\nHaz la diferencia."}'
];

$setParts = [];
$params = [];
foreach ($updates as $col => $val) {
    $setParts[] = "`$col` = :$col";
    $params[":$col"] = $val;
}

try {
    $stmt = $pdo->prepare("UPDATE `website_settings` SET " . implode(", ", $setParts) . " LIMIT 1");
    $stmt->execute($params);
    echo "<p class='ok'>✅ Successfully restored the missing text and numbers to the database!</p>";
    
    foreach ($updates as $col => $val) {
        echo "<p>Restored <strong>$col</strong>: " . htmlspecialchars($val) . "</p>";
    }
} catch (Exception $e) {
    echo "<p class='bad'>❌ Database Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<hr><strong>Done! Please clear Laravel cache and refresh the homepage.</strong>";
?>
