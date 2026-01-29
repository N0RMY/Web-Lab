<?php
require_once __DIR__ . "/db.php";

$from = $_GET["from"] ?? "";
$to   = $_GET["to"] ?? "";

if ($from === "" || $to === "") {
    http_response_code(400);
    echo "Вкажи from і to";
    exit;
}

// нормальна перевірка формату YYYY-MM-DD
if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $from) || !preg_match("/^\d{4}-\d{2}-\d{2}$/", $to)) {
    http_response_code(400);
    echo "Невірний формат дат";
    exit;
}

// to включно: додаємо кінець дня
$toEnd = $to . " 23:59:59";

$stmt = $conn->prepare("
  SELECT id, name, price, address, sold_at
  FROM houses
  WHERE is_sold = 1 AND sold_at BETWEEN ? AND ?
  ORDER BY sold_at DESC
");
$stmt->bind_param("ss", $from, $toEnd);
$stmt->execute();
$res = $stmt->get_result();

header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=sold_houses_{$from}_{$to}.csv");

$out = fopen("php://output", "w");
fputcsv($out, ["id", "name", "price", "address", "sold_at"]);

while ($row = $res->fetch_assoc()) {
    fputcsv($out, [$row["id"], $row["name"], $row["price"], $row["address"], $row["sold_at"]]);
}
fclose($out);
