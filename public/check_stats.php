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
echo "<h2>Stats & Content Fields in website_settings</h2>";

$row = $pdo->query("SELECT peaple_helped, volunteers, educated_children, service_meal, help_people_need_content, our_numbers_content FROM website_settings LIMIT 1")->fetch(PDO::FETCH_ASSOC);

foreach ($row as $col => $val) {
    $class = empty($val) ? 'bad' : 'ok';
    echo "<p class='$class'><strong>$col</strong>: " . (empty($val) ? '❌ EMPTY' : htmlspecialchars(substr($val, 0, 200))) . "</p>";
}

echo "<hr><strong>Done!</strong>";
?>
