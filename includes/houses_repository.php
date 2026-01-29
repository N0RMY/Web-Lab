<?php
require_once __DIR__ . "/db.php";

function getCategories(mysqli $conn): array {
    $rows = [];
    $res = $conn->query("SELECT id, name FROM categories ORDER BY name");
    while ($r = $res->fetch_assoc()) $rows[] = $r;
    return $rows;
}

function getHouses(mysqli $conn, int $limit, string $name, int $min, int $max, int $cat): array {
    $sql = "
      SELECT h.*, c.name AS category_name
      FROM houses h
      LEFT JOIN categories c ON c.id = h.category_id
      WHERE 1=1
        AND h.price BETWEEN ? AND ?
    ";

    $types = "ii";
    $params = [$min, $max];

    if ($name !== "") {
        $sql .= " AND h.name LIKE ? ";
        $types .= "s";
        $params[] = "%" . $name . "%";
    }

    if ($cat > 0) {
        $sql .= " AND h.category_id = ? ";
        $types .= "i";
        $params[] = $cat;
    }

    $sql .= " ORDER BY h.id DESC LIMIT ? ";
    $types .= "i";
    $params[] = $limit;

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();

    $rows = [];
    $res = $stmt->get_result();
    while ($r = $res->fetch_assoc()) $rows[] = $r;
    return $rows;
}

function getSliderHouses(mysqli $conn): array {
    $rows = [];
    $res = $conn->query("
      SELECT h.*, c.name AS category_name
      FROM houses h
      LEFT JOIN categories c ON c.id = h.category_id
      WHERE h.is_slider = 1
      ORDER BY h.id DESC
      LIMIT 12
    ");
    while ($r = $res->fetch_assoc()) $rows[] = $r;
    return $rows;
}
