<?php
require_once __DIR__ . "/../classes/House.php";

function getDiscount(): int {
    $discounts = [0, 0, 0, 5, 10, 15, 20];
    return $discounts[array_rand($discounts)];
}

// Завдання 5 (з ЛР8): повертає стільки будинків, скільки вказано
function generateHouses(int $count): array {
    $result = [];

    $templates = [
        ["Modern Villa", 155000, "Київ, Оболонь", "+380935553322", "img/house1.jpg", 3, 2],
        ["Cozy Cottage", 99000, "Львів, Центр", "+380501111111", "img/house2.jpg", 2, 1],
        ["Premium House", 230000, "Одеса, Аркадія", "+380678889900", "img/house3.jpg", 4, 3],
    ];

    for ($i = 0; $i < $count; $i++) {
        $t = $templates[$i % count($templates)];
        $name = $t[0] . " #" . ($i + 1);
        $result[] = new House($name, $t[1], $t[2], $t[3], $t[4], $t[5], $t[6]);
    }

    return $result;
}
