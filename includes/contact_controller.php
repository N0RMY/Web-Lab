<?php
require_once __DIR__ . "/helpers.php";
require_once __DIR__ . "/../classes/ContactInformation.php";

$errors = [];
$contactObj = null;
$avgLen = null;
$shouldFocusFirst = false;

// значення форми (щоб не зникали при помилках)
$form = [
    "name" => "",
    "email" => "",
    "birth_date" => "",
    "subject" => "",
    "message" => ""
];

// Завдання 2: Очистити форму (обробляє PHP)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["clear"])) {
    $shouldFocusFirst = true; // після очистки фокус на перше поле
}
// Submit
elseif ($_SERVER["REQUEST_METHOD"] === "POST") {

    $form["name"] = trim($_POST["name"] ?? "");
    $form["email"] = trim($_POST["email"] ?? "");
    $form["birth_date"] = trim($_POST["birth_date"] ?? "");
    $form["subject"] = trim($_POST["subject"] ?? "");
    $form["message"] = trim($_POST["message"] ?? "");

    // Завдання 1: валідація email regex + дата не в майбутньому
    if ($form["name"] === "") $errors[] = "Поле Ім'я є обов'язковим.";
    if ($form["email"] === "" || !isValidEmailRegex($form["email"])) $errors[] = "Некоректний Email (regex).";
    if ($form["birth_date"] === "") $errors[] = "Дата народження є обов'язковою.";
    if ($form["birth_date"] !== "" && !isBirthDateNotFuture($form["birth_date"])) $errors[] = "Дата народження не може бути в майбутньому.";
    if ($form["subject"] === "") $errors[] = "Поле Тема є обов'язковим.";
    if ($form["message"] === "") $errors[] = "Поле Повідомлення є обов'язковим.";

    if (!$errors) {
        $contactObj = new ContactInformation(
            $form["name"],
            $form["email"],
            $form["birth_date"],
            $form["subject"],
            $form["message"]
        );

        // Завдання 4: середня довжина
        $avgLen = averageTextLength([
            $form["name"],
            $form["email"],
            $form["birth_date"],
            $form["subject"],
            $form["message"]
        ]);
    }
}
