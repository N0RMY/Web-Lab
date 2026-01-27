<?php
declare(strict_types=1);

set_time_limit(5);
ini_set('display_errors', '1');
error_reporting(E_ALL);

$dbname = 'electroshop_db';
$user = 'root';
$pass = '';
$port = 3306;

// Спробуємо типові адреси + ті, які ти бачив у netstat
$hosts = [
  '127.0.0.1',
  'localhost',
  '127.0.1.1',
  '127.0.1.11',
  '127.0.1.16',
  '127.0.1.17',
  '127.0.1.26',
  '127.0.1.27',
  '127.0.1.28',
];

echo "<pre>";
echo "Testing MySQL connection to DB: {$dbname}\n\n";

foreach ($hosts as $host) {
  $mysqli = mysqli_init();
  mysqli_options($mysqli, MYSQLI_OPT_CONNECT_TIMEOUT, 2);

  $ok = @mysqli_real_connect($mysqli, $host, $user, $pass, $dbname, $port);

  if ($ok) {
    echo "✅ OK: {$host}:{$port} (server: " . mysqli_get_server_info($mysqli) . ")\n";
    mysqli_close($mysqli);
    echo "\nDONE. Use this host in your db.php: {$host}\n";
    echo "</pre>";
    exit;
  } else {
    $err = mysqli_connect_error();
    echo "❌ FAIL: {$host}:{$port} | {$err}\n";
  }

  mysqli_close($mysqli);
}

echo "\nNo host worked.\n";
echo "</pre>";
