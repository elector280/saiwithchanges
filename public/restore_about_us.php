<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$envFile = __DIR__ . '/../.env';
$env = [];
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            [$key, $val] = explode('=', $line, 2);
            $env[trim($key)] = trim($val, " 	\n\r\0\x0B\"'");
        }
    }
}

$pdo = new PDO("mysql:host={$env['DB_HOST']};dbname={$env['DB_DATABASE']};charset=utf8", $env['DB_USERNAME'], $env['DB_PASSWORD']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "<style>body{font-family:monospace;font-size:13px;} .ok{color:green;} .bad{color:red;}</style>";
echo "<h2>Restoring About Us Fields</h2>";

$updates = array (
  'about_us_title_home' => '{"en":"What We Do <br/>  To Help","es":"Lo que hacemos <br/> para ayudar"}',
  'about_us_content_home' => '{"en":"South American Initiative is a U.S. based nonprofit organization
providing food and medical care for orphans, sick children, 
newborn infants, expectant mothers, and seniors, and food and 
shelter to abandoned dogs and zoo animals in Venezuela.","es":"South American Initiative es una organización sin fines de lucro con
 sede en Estados Unidos que brinda alimentos y atención médica a
 huérfanos, niños enfermos, recién nacidos, mujeres embarazadas 
y personas mayores, así como alimento y refugio a perros y animales
 de zoológicos abandonados en Venezuela."}',
);

$setParts = [];
$params = [];
foreach ($updates as $col => $val) {
    $setParts[] = "`$col` = :$col";
    $params[":$col"] = $val;
}

try {
    $stmt = $pdo->prepare("UPDATE `website_settings` SET " . implode(", ", $setParts) . " LIMIT 1");
    $stmt->execute($params);
    echo "<p class='ok'>✅ Successfully restored About Us content!</p>";
} catch (Exception $e) {
    echo "<p class='bad'>❌ Database Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}
echo "<hr><strong>Done! Please clear Laravel cache and refresh the homepage.</strong>";
?>