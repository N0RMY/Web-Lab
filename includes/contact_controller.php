<?php
require_once __DIR__ . "/db.php";

function saveContact($data)
{
    global $conn;

    $name  = mysqli_real_escape_string($conn, $data['name']);
    $email = mysqli_real_escape_string($conn, $data['email']);
    $date  = mysqli_real_escape_string($conn, $data['birth_date']);
    $msg   = mysqli_real_escape_string($conn, $data['message']);

    $sql = "
        INSERT INTO contacts (name, email, birth_date, message)
        VALUES ('$name', '$email', '$date', '$msg')
    ";

    if (mysqli_query($conn, $sql)) {
        return "Дані успішно збережені в БД";
    } else {
        return "Помилка запису: " . mysqli_error($conn);
    }
}
