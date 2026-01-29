<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/db.php";

function h(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

// Дати з GET
$from = (string)($_GET["from"] ?? "");
$to   = (string)($_GET["to"] ?? "");
$download = (int)($_GET["download"] ?? 0);

// Перевірка формату YYYY-MM-DD
function isDateOk(string $d): bool {
    return (bool)preg_match("/^\d{4}-\d{2}-\d{2}$/", $d);
}

$soldRows = [];
$error = "";

if ($from !== "" || $to !== "") {
    if (!isDateOk($from) || !isDateOk($to)) {
        $error = "Невірний формат дат. Використовуй YYYY-MM-DD.";
    } else {
        // "to" включно
        $toEnd = $to . " 23:59:59";

        $stmt = $conn->prepare("
            SELECT id, name, price, address, sold_at
            FROM houses
            WHERE is_sold = 1 AND sold_at BETWEEN ? AND ?
            ORDER BY sold_at DESC
        ");
        $stmt->bind_param("ss", $from, $toEnd);
        $stmt->execute();
        $res = $stmt->get_result();

        while ($row = $res->fetch_assoc()) {
            $soldRows[] = $row;
        }

        // Якщо download=1 -> віддаємо CSV
        if ($download === 1) {
            header("Content-Type: text/csv; charset=utf-8");
            header("Content-Disposition: attachment; filename=sold_houses_{$from}_{$to}.csv");

            $out = fopen("php://output", "w");
            fputcsv($out, ["id", "name", "price", "address", "sold_at"]);

            foreach ($soldRows as $r) {
                fputcsv($out, [$r["id"], $r["name"], $r["price"], $r["address"], $r["sold_at"]]);
            }

            fclose($out);
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lab11 — Звітність</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900">

<header class="bg-black text-white">
    <div class="max-w-5xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold">Звітність (Lab11)</h1>
        <p class="opacity-80 mt-1">Продані будинки за період + CSV</p>

        <div class="mt-4">
            <a class="bg-white/15 hover:bg-white/20 px-4 py-2 rounded-xl"
               href="lab11.php">
                ← Назад до Lab11
            </a>
        </div>
    </div>
</header>

<main class="max-w-5xl mx-auto px-4 py-8">

    <section class="bg-white rounded-2xl shadow p-5">
        <h2 class="text-xl font-bold mb-4">Отримати звіт</h2>

        <?php if ($error): ?>
            <div class="mb-4 p-3 rounded-xl bg-red-50 text-red-700 border border-red-200">
                <?= h($error) ?>
            </div>
        <?php endif; ?>

        <form method="get" class="flex gap-4 flex-wrap items-end">
            <div>
                <label class="block text-sm font-medium mb-1">Початкова дата</label>
                <input type="date" name="from" value="<?= h($from) ?>"
                       class="border rounded-xl p-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Кінцева дата</label>
                <input type="date" name="to" value="<?= h($to) ?>"
                       class="border rounded-xl p-2" required>
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700">
                Показати на сторінці
            </button>

            <button name="download" value="1"
                    class="bg-black text-white px-4 py-2 rounded-xl hover:bg-slate-800">
                Скачати CSV
            </button>
        </form>
    </section>

    <section class="mt-8">
        <h2 class="text-xl font-bold mb-3">Результат</h2>

        <?php if ($from === "" || $to === ""): ?>
            <div class="bg-white p-5 rounded-2xl shadow">
                Вибери дати і натисни “Показати на сторінці” або “Скачати CSV”.
            </div>
        <?php elseif ($error): ?>
            <div class="bg-white p-5 rounded-2xl shadow">
                Виправ дати і повтори.
            </div>
        <?php elseif (count($soldRows) === 0): ?>
            <div class="bg-white p-5 rounded-2xl shadow">
                Немає проданих будинків у період <b><?= h($from) ?></b> — <b><?= h($to) ?></b>.
            </div>
        <?php else: ?>
            <div class="bg-white rounded-2xl shadow overflow-hidden">
                <div class="p-4 border-b">
                    Знайдено: <b><?= count($soldRows) ?></b>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-100">
                        <tr>
                            <th class="text-left p-3">ID</th>
                            <th class="text-left p-3">Назва</th>
                            <th class="text-left p-3">Ціна</th>
                            <th class="text-left p-3">Адреса</th>
                            <th class="text-left p-3">Дата продажу</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($soldRows as $r): ?>
                            <tr class="border-t">
                                <td class="p-3"><?= (int)$r["id"] ?></td>
                                <td class="p-3"><?= h((string)$r["name"]) ?></td>
                                <td class="p-3">$<?= (int)$r["price"] ?></td>
                                <td class="p-3"><?= h((string)$r["address"]) ?></td>
                                <td class="p-3"><?= h((string)$r["sold_at"]) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </section>

</main>

<footer class="mt-10 bg-white border-t">
    <div class="max-w-5xl mx-auto px-4 py-6 text-sm opacity-80">
        © <?= date("Y") ?> Lab11 • Звітність
    </div>
</footer>

</body>
</html>
