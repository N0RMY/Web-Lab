<?php 
require_once "includes/functions_lab6.php";
require_once "classes/House.php";
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Лабораторна №6</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <h1>Лабораторна робота №6</h1>
  <p>Функції, об’єкти, цикли та динамічний контент</p>
</header>

<main>

<!-- Завдання 3 — About -->
<?= getAboutBlock(); ?>

<?php
// Завдання 6 — створюємо об’єкти
$houses = [
    new House("Modern Villa", 155000, "Київ, Оболонь", "+380935553322", "img/house1.jpg", 3, 2),
    new House("Cozy Cottage", 99000, "Львів, Центр", "+380501111111", "img/house2.jpg", 2, 1),
    new House("Premium House", 230000, "Одеса, Аркадія", "+380678889900", "img/house3.jpg", 4, 3),
];
?>

<h2 style="text-align:center; margin-top:2rem;">Список будинків</h2>

<section class="products">

<?php foreach ($houses as $h): ?>
    <?php $sale = getDiscount(); ?>

    <div class="product">
        <img src="<?= $h->image ?>" alt="<?= $h->name ?>" class="product-image">

        <h2><?= $h->name ?></h2>

        <?php if ($sale > 0): ?>
            <p><s><?= $h->price ?>$</s></p>
            <p style="color:red; font-size:20px; font-weight:bold;">
                <?= $h->price - ($h->price * $sale / 100) ?>$ (−<?= $sale ?>%)
            </p>
        <?php else: ?>
            <p><?= $h->price ?>$</p>
        <?php endif; ?>

        <p><strong>Адреса:</strong> <?= $h->address ?></p>
        <p><strong>Спальні:</strong> <?= $h->beds ?> | <strong>Ванни:</strong> <?= $h->baths ?></p>
        <p><strong>Телефон:</strong> <?= $h->phone ?></p>
    </div>

<?php endforeach; ?>

</section>

</main>

<!-- Завдання 4 + 5 -->
<footer>
    <p>Локація: Київ, Україна</p>
    <p>© <?= date("Y") ?> Всі права захищені</p>
</footer>

</body>
</html>
