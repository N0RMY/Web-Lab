<?php

function h(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function averageTextLength(array $fields): float {
    $lengths = [];
    foreach ($fields as $value) {
        $value = trim((string)$value);
        $lengths[] = mb_strlen($value);
    }
    if (!$lengths) return 0;
    return array_sum($lengths) / count($lengths);
}

function isValidEmailRegex(string $email): bool {
    $emailRegex = '/^[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,}$/';
    return (bool)preg_match($emailRegex, $email);
}

function isBirthDateNotFuture(string $birthDate): bool {
    $birthTs = strtotime($birthDate);
    if ($birthTs === false) return false;
    $todayTs = strtotime(date("Y-m-d"));
    return $birthTs <= $todayTs;
}
