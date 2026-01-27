<?php
require_once __DIR__ . "/helpers.php";
require_once __DIR__ . "/contacts_repository.php";
require_once __DIR__ . "/../classes/ContactInformation.php";

$errors = [];
$contactObj = null;
$avgLen = null;
$dbMessage = null;
$shouldFocusFirst = false;

$form = [
    "name" => "",
    "email" => "",
    "birth_date" => "",
    "subject" => "",
    "message" => ""
];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["clear"])) {
    $shouldFocusFirst = true;
}
elseif ($_SERVER["REQUEST_METHOD"] === "POST") {

    $form["name"] = trim($_POST["name"] ?? "");
    $form["email"] = trim($_POST["email"] ?? "");
    $form["birth_date"] = trim($_POST["birth_date"] ?? "");
    $form["subject"] = trim($_POST["subject"] ?? "");
    $form["message"] = trim($_POST["message"] ?? "");

    // Валідація як у Lab9
    if ($form["name"] === "") $errors[] = "Поле Ім'я обов'язкове.";
    if ($form["email"] === "" || !isValidEmailRegex($form["email"])) $errors[] = "Некоректний Email.";
    if ($form["birth_date"] === "" || !isBirthDateNotFuture($form["birth_date"])) $errors[] = "Некоректна дата народження.";
    if ($form["subject"] === "") $errors[] = "Поле Тема обов'язкове.";
    if ($form["message"] === "") $errors[] = "Поле Повідомлення обов'язкове.";

    if (!$errors) {
        $contactObj = new ContactInformation(
            $form["name"],
            $form["email"],
            $form["birth_date"],
            $form["subject"],
            $form["message"]
        );

        // Завдання 4 з Lab9 (залишаємо)
        $avgLen = averageTextLength([
            $form["name"], $form["email"], $form["birth_date"], $form["subject"], $form["message"]
        ]);

        // ✅ Lab10: запис у БД (contacts)
        [$ok, $msg] = save_contact_to_db([
            "name" => $contactObj->name,
            "email" => $contactObj->email,
            "birthdate" => $contactObj->birthDate,
            "subject" => $contactObj->subject,
            "message" => $contactObj->message
        ]);

        $dbMessage = [$ok, $msg];
    }
}
