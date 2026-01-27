<?php
require_once __DIR__ . "/houses_repository.php";

$housesCount = 3;
if (isset($_GET["houses"])) {
    $housesCount = (int)$_GET["houses"];
    if ($housesCount < 3) $housesCount = 3;
    if ($housesCount > 60) $housesCount = 60;
}

$showMoreLink = "?houses=" . ($housesCount + 3) . "#houses";
$showLessLink = "?houses=" . max(3, $housesCount - 3) . "#houses";

$houses = get_houses_from_db($housesCount);
