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
echo "<h2>Restoring About Us Fields (Fixed JSON)</h2>";

// Properly encode JSON so MySQL's JSON constraint doesn't fail.
$title = [
    "en" => "What We Do <br/>  To Help",
    "es" => "Lo que hacemos <br/> para ayudar"
];

$content = [
    "en" => "South American Initiative is a U.S. based nonprofit organization\nproviding food and medical care for orphans, sick children, \nnewborn infants, expectant mothers, and seniors, and food and \nshelter to abandoned dogs and zoo animals in Venezuela.",
    "es" => "South American Initiative es una organización sin fines de lucro con\n sede en Estados Unidos que brinda alimentos y atención médica a\n huérfanos, niños enfermos, recién nacidos, mujeres embarazadas \ny personas mayores, así como alimento y refugio a perros y animales\n de zoológicos abandonados en Venezuela."
];

$updates = [
    'about_us_title_home' => json_encode($title, JSON_UNESCAPED_UNICODE),
    'about_us_content_home' => json_encode($content, JSON_UNESCAPED_UNICODE)
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
    echo "<p class='ok'>✅ Successfully restored About Us content! JSON is valid.</p>";
} catch (Exception $e) {
    echo "<p class='bad'>❌ Database Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<hr><strong>Done! Please clear Laravel cache and refresh the homepage.</strong>";
?>