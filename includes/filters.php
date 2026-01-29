<?php

function getFilters(): array {
    $name = trim((string)($_GET["name"] ?? ""));
    $min = (int)($_GET["min_price"] ?? 0);
    $max = (int)($_GET["max_price"] ?? 100000000);
    $cat = (int)($_GET["category_id"] ?? 0);

    if ($min < 0) $min = 0;
    if ($max < $min) $max = $min;

    return [$name, $min, $max, $cat];
}
