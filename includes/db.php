<?php

$host = '127.0.1.28';   // IP MySQL з hosts
$user = 'root';
$pass = '';
$db   = 'electroshop_db';
$port = 3306;

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die('Помилка підключення до БД: ' . $conn->connect_error);
}

$conn->set_charset('utf8mb4');
