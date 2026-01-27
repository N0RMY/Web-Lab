<?php

class ContactInformation
{
    public string $name;
    public string $email;
    public string $birthDate; // YYYY-MM-DD
    public string $subject;
    public string $message;

    public function __construct(
        string $name,
        string $email,
        string $birthDate,
        string $subject,
        string $message
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->birthDate = $birthDate;
        $this->subject = $subject;
        $this->message = $message;
    }

    // Завдання 5 — метод, який форматує дані як HTML-таблицю
    public function toHtmlTable(): string
    {
        $rows = [
            "Імʼя" => $this->name,
            "Email" => $this->email,
            "Дата народження" => $this->birthDate,
            "Тема" => $this->subject,
            "Повідомлення" => $this->message,
        ];

        $html = '<table border="1" cellpadding="8" cellspacing="0"
                  style="border-collapse:collapse; margin-top:12px;">';

        foreach ($rows as $key => $value) {
            $html .= "<tr>
                        <th style='text-align:left'>" . htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . "</th>
                        <td>" . nl2br(htmlspecialchars($value, ENT_QUOTES, 'UTF-8')) . "</td>
                      </tr>";
        }

        $html .= "</table>";

        return $html;
    }
}
