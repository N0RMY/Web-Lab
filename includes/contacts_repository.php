<?php
// includes/contacts_repository.php
require_once __DIR__ . "/db.php";

function save_contact_to_db(array $data): array
{
    global $conn;

    $sql = "INSERT INTO contacts (name, email, birthdate, subject, message)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return [false, "Помилка prepare(): " . $conn->error];
    }

    $stmt->bind_param(
        "sssss",
        $data["name"],
        $data["email"],
        $data["birthdate"],
        $data["subject"],
        $data["message"]
    );

    if (!$stmt->execute()) {
        return [false, "Помилка execute(): " . $stmt->error];
    }

    return [true, "✅ Дані Contact Me успішно збережено в БД."];
}
