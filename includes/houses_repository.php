<?php
require_once __DIR__ . "/db.php";

function get_houses_from_db(int $limit): array
{
    global $conn;

    if ($limit < 3) $limit = 3;
    if ($limit > 60) $limit = 60;

    $sql = "SELECT id, name, price, address, phone, image, beds, baths
            FROM houses
            ORDER BY id ASC
            LIMIT ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) return [];

    $stmt->bind_param("i", $limit);
    $stmt->execute();

    $result = $stmt->get_result();
    $houses = [];

    while ($row = $result->fetch_assoc()) {
        $houses[] = $row;
    }

    return $houses;
}
