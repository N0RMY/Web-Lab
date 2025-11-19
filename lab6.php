<?php 
require_once "includes/functions_lab6.php";
require_once "classes/House.php";
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Лабораторна №6 — PHP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Лабораторна робота №6</h1>

<!-- Завдання 3 -->
<?= getAboutBlock(); ?>

<?php
// Завдання 6 — створення будинків
$houses = [
    new House("Modern Villa", 155000, "Київ, Оболонь", "+380935553322", "img/house1.jpg", 3, 2),
    new House("Cozy Cottage", 99000, "Львів, Центр", "+380501111111", "img/house2.jpg", 2, 1),
    new House("Premium House", 230000, "Одеса, Аркадія", "+380678889900", "img/house3.jpg", 4, 3),
];
?>

<h2>Список будинків</h2>

<section class="houses">

<?php foreach ($houses as $h): ?>
    <?php $sale = getDiscount(); ?>

    <div class="house">
        <img src="<?= $h->image ?>" alt="<?= $h->name ?>" class="house-img">

        <h3><?= $h->name ?></h3>

        <?php if ($sale > 0): ?>
            <p><s><?= $h->price ?>$</s></p>
            <p style="color:red;font-size:20px;font-weight:bold;">
                <?= $h->price - ($h->price * $sale / 100) ?>$ (−<?= $sale ?>%)
            </p>
        <?php else: ?>
            <p><?= $h->price ?>$</p>
        <?php endif; ?>

        <p>Адреса: <?= $h->address ?></p>
        <p>Спальні: <?= $h->beds ?> | Ванни: <?= $h->baths ?></p>
        <p>Телефон: <?= $h->phone ?></p>
    </div>

<?php endforeach; ?>

</section>

<!-- Завдання 4 + 5 -->
<footer style="margin-top:40px;">
    <div>Локація: Київ, Україна</div>
    <div>© <?= date("Y") ?></div>
</footer>

</body>
</html>
