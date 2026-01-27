<?php
require_once __DIR__ . "/functions_houses.php";

$housesCount = 3;

if (isset($_GET["houses"])) {
    $housesCount = (int)$_GET["houses"];
    if ($housesCount < 3) $housesCount = 3;
    if ($housesCount > 60) $housesCount = 60;
}

// Завдання 3: кнопка "Показати менше" зменшує на 3 (мінімум 3)
$showMoreLink = "?houses=" . ($housesCount + 3) . "#houses";
$showLessLink = "?houses=" . max(3, $housesCount - 3) . "#houses";

$houses = generateHouses($housesCount);
