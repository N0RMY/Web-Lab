<?php
require_once __DIR__ . "/db.php";

header("Content-Type: application/json; charset=utf-8");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["ok" => false, "error" => "Method not allowed"]);
    exit;
}

$houseId = (int)($_POST["house_id"] ?? 0);
if ($houseId <= 0) {
    http_response_code(400);
    echo json_encode(["ok" => false, "error" => "Bad house_id"]);
    exit;
}

/**
 * Захист від накрутки:
 * Зберігаємо список лайкнутих будинків в cookie "liked_houses" як JSON-масив ID.
 */
$cookieName = "liked_houses";
$liked = [];

if (!empty($_COOKIE[$cookieName])) {
    $decoded = json_decode($_COOKIE[$cookieName], true);
    if (is_array($decoded)) $liked = $decoded;
}

if (in_array($houseId, $liked, true)) {
    echo json_encode(["ok" => false, "alreadyLiked" => true]);
    exit;
}

// +1 лайк в БД
$stmt = $conn->prepare("UPDATE houses SET likes = likes + 1 WHERE id = ?");
$stmt->bind_param("i", $houseId);
$stmt->execute();

$stmt2 = $conn->prepare("SELECT likes FROM houses WHERE id = ?");
$stmt2->bind_param("i", $houseId);
$stmt2->execute();
$res = $stmt2->get_result()->fetch_assoc();

$liked[] = $houseId;

// cookie на 30 днів
setcookie($cookieName, json_encode($liked), time() + 60 * 60 * 24 * 30, "/");

echo json_encode(["ok" => true, "likes" => (int)$res["likes"]]);
