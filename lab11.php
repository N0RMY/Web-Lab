<?php
declare(strict_types=1);

// === ПІДКЛЮЧЕННЯ ===
require_once __DIR__ . "/includes/db.php";
require_once __DIR__ . "/includes/filters.php";
require_once __DIR__ . "/includes/houses_repository.php";

// helper для HTML
function h(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

// === ЛІМІТ БУДИНКІВ (GET houses) + show more/less ===
$limit = (int)($_GET["houses"] ?? 3);
if ($limit < 3) $limit = 3;
if ($limit > 60) $limit = 60;

// show more/less через GET action
$action = $_GET["action"] ?? "";
if ($action === "more") {
    $limit += 3;
    if ($limit > 60) $limit = 60;
}
if ($action === "less") {
    $limit -= 3;
    if ($limit < 3) $limit = 3;
}

// === ФІЛЬТРИ (завд. 6) ===
[$nameFilter, $minPrice, $maxPrice, $categoryId] = getFilters();

// === ДАНІ З БД ===
$categories = getCategories($conn);
$sliderHouses = getSliderHouses($conn);
$houses = getHouses($conn, $limit, $nameFilter, $minPrice, $maxPrice, $categoryId);

// === ЗРУЧНО ДЛЯ ПОБУДОВИ URL З НАЯВНИМИ GET ПАРАМЕТРАМИ ===
function buildUrl(array $overrides = []): string {
    $q = $_GET;
    foreach ($overrides as $k => $v) {
        if ($v === null) unset($q[$k]);
        else $q[$k] = $v;
    }
    $query = http_build_query($q);
    return basename(__FILE__) . ($query ? ("?" . $query) : "");
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lab11 — Будинки + Лайки + Фільтри + Звіт</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900">

<header class="bg-blue-600 text-white">
    <div class="max-w-6xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold">Лабораторна робота №11</h1>
        <p class="opacity-90 mt-1">MySQL + PHP: лайки, категорії, фільтри, слайдер, звітність</p>

        <div class="mt-4 flex gap-3 flex-wrap">
            <a class="bg-white/15 hover:bg-white/20 px-4 py-2 rounded-xl"
               href="<?= h(buildUrl(["name" => null, "min_price" => 0, "max_price" => 100000000, "category_id" => 0, "houses" => 3, "action" => null])) ?>">
                Скинути фільтри
            </a>

            <a class="bg-white text-blue-700 hover:bg-blue-50 px-4 py-2 rounded-xl font-semibold"
               href="report.php">
                Перейти до звітності
            </a>
        </div>
    </div>
</header>

<main class="max-w-6xl mx-auto px-4 py-8">

    <!-- === СЕКЦІЯ: ВІДІБРАНІ ДЛЯ СЛАЙДЕРА (завд. 4) === -->
    <section class="mb-10">
        <h2 class="text-2xl font-bold mb-4">Відібрані для слайдера</h2>

        <?php if (count($sliderHouses) === 0): ?>
            <div class="bg-white p-4 rounded-2xl shadow">
                Немає будинків з <code>is_slider = 1</code>.
            </div>
        <?php else: ?>
            <div class="flex gap-4 overflow-x-auto pb-3">
                <?php foreach ($sliderHouses as $hRow): ?>
                    <div class="min-w-[280px] bg-white rounded-2xl shadow p-4">
                        <img class="rounded-xl w-full h-40 object-cover"
                             src="<?= h((string)$hRow["image"]) ?>"
                             alt="<?= h((string)$hRow["name"]) ?>">

                        <div class="mt-3">
                            <div class="font-semibold text-lg"><?= h((string)$hRow["name"]) ?></div>
                            <div class="text-sm opacity-70">
                                Категорія: <?= h((string)($hRow["category_name"] ?? "—")) ?>
                            </div>

                            <div class="mt-2 font-bold text-xl">$<?= (int)$hRow["price"] ?></div>

                            <?php if ((int)$hRow["is_sold"] === 1): ?>
                                <div class="mt-2 text-sm text-red-600 font-semibold">
                                    Продано ✅ (<?= h((string)($hRow["sold_at"] ?? "")) ?>)
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <!-- === ФІЛЬТРИ (завд. 6) === -->
    <section class="mb-10 bg-white rounded-2xl shadow p-5">
        <h2 class="text-xl font-bold mb-4">Фільтри</h2>

        <form method="get" class="grid md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium mb-1">Назва будинку</label>
                <input type="text" name="name" value="<?= h($nameFilter) ?>"
                       class="w-full border rounded-xl p-2" placeholder="Напр. Villa">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Ціна від</label>
                <input type="number" name="min_price" value="<?= (int)$minPrice ?>"
                       class="w-full border rounded-xl p-2" min="0">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Ціна до</label>
                <input type="number" name="max_price" value="<?= (int)$maxPrice ?>"
                       class="w-full border rounded-xl p-2" min="0">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Категорія</label>
                <select name="category_id" class="w-full border rounded-xl p-2">
                    <option value="0">— Всі —</option>
                    <?php foreach ($categories as $c): ?>
                        <option value="<?= (int)$c["id"] ?>" <?= ((int)$c["id"] === (int)$categoryId) ? "selected" : "" ?>>
                            <?= h((string)$c["name"]) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <input type="hidden" name="houses" value="<?= (int)$limit ?>">

            <div class="md:col-span-4 flex gap-3 flex-wrap mt-2">
                <button class="bg-black text-white px-4 py-2 rounded-xl">Застосувати</button>
                <a class="px-4 py-2 rounded-xl border"
                   href="<?= h(buildUrl(["name" => null, "min_price" => 0, "max_price" => 100000000, "category_id" => 0])) ?>">
                    Скинути
                </a>
            </div>
        </form>
    </section>

    <!-- === СПИСОК БУДИНКІВ + ЛАЙКИ (завд. 2–3) + sold info (завд. 7) + category (завд. 5) === -->
    <section>
        <h2 class="text-2xl font-bold mb-4">Список будинків</h2>

        <?php if (count($houses) === 0): ?>
            <div class="bg-white p-5 rounded-2xl shadow">
                Нічого не знайдено за вашими фільтрами.
            </div>
        <?php else: ?>
            <div class="grid md:grid-cols-3 gap-5">
                <?php foreach ($houses as $hRow): ?>
                    <article class="bg-white rounded-2xl shadow p-4">
                        <img class="rounded-xl w-full h-44 object-cover"
                             src="<?= h((string)$hRow["image"]) ?>"
                             alt="<?= h((string)$hRow["name"]) ?>">

                        <div class="mt-3">
                            <h3 class="text-lg font-semibold"><?= h((string)$hRow["name"]) ?></h3>

                            <div class="text-sm opacity-70">
                                Категорія: <?= h((string)($hRow["category_name"] ?? "—")) ?>
                            </div>

                            <div class="mt-2 font-bold text-xl">
                                $<?= (int)$hRow["price"] ?>
                            </div>

                            <div class="mt-2 text-sm">
                                <div><span class="font-semibold">Адреса:</span> <?= h((string)$hRow["address"]) ?></div>
                                <div><span class="font-semibold">Телефон:</span> <?= h((string)$hRow["phone"]) ?></div>
                                <div><span class="font-semibold">Спальні:</span> <?= (int)$hRow["beds"] ?> |
                                     <span class="font-semibold">Ванни:</span> <?= (int)$hRow["baths"] ?>
                                </div>
                            </div>

                            <?php if ((int)$hRow["is_sold"] === 1): ?>
                                <div class="mt-2 text-sm text-red-600 font-semibold">
                                    Продано ✅ (<?= h((string)($hRow["sold_at"] ?? "")) ?>)
                                </div>
                            <?php endif; ?>

                            <!-- ЛАЙК -->
                            <button
                                class="mt-3 px-3 py-2 rounded-xl border hover:bg-slate-50"
                                data-like-house="<?= (int)$hRow["id"] ?>"
                            >
                                Лайк ❤️ (
                                <span data-like-count="<?= (int)$hRow["id"] ?>"><?= (int)$hRow["likes"] ?></span>
                                )
                            </button>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- SHOW MORE / LESS (завд. 3 + логіка houses) -->
        <div class="mt-6 flex gap-3 flex-wrap">
            <a class="px-4 py-2 rounded-xl border"
               href="<?= h(buildUrl(["action" => "less", "houses" => $limit])) ?>">
                Показати менше
            </a>

            <a class="px-4 py-2 rounded-xl bg-blue-600 text-white hover:bg-blue-700"
               href="<?= h(buildUrl(["action" => "more", "houses" => $limit])) ?>">
                Показати більше
            </a>

            <div class="px-4 py-2 rounded-xl bg-white border">
                Зараз показано: <b><?= (int)$limit ?></b>
            </div>
        </div>
    </section>

</main>

<footer class="mt-10 bg-white border-t">
    <div class="max-w-6xl mx-auto px-4 py-6 text-sm opacity-80">
        © <?= date("Y") ?> Lab11 • electroshop
    </div>
</footer>

<!-- JS для лайків -->
<script src="/public/js/likes.js"></script>

</body>
</html>
