<?php
require_once "classes/House.php";
require_once "includes/functions_lab8.php";
require_once "classes/ContactInformation.php";

$housesCount = 3;
if (isset($_GET["houses"])) {
    $housesCount = (int)$_GET["houses"];
    if ($housesCount < 3) $housesCount = 3;
    if ($housesCount > 60) $housesCount = 60; // захист від "999999"
}
$houses = generateHouses($housesCount);

$contactObj = null;
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $subject = trim($_POST["subject"] ?? "");
    $message = trim($_POST["message"] ?? "");

    // всі поля обов'язкові
    if ($name === "") $errors[] = "Поле Ім'я є обов'язковим.";
    if ($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email є обов'язковим та має бути коректним.";
    if ($subject === "") $errors[] = "Поле Тема є обов'язковим.";
    if ($message === "") $errors[] = "Поле Повідомлення є обов'язковим.";

    if (empty($errors)) {
        $contactObj = new ContactInformation($name, $email, $subject, $message);
    }
}

$nextHouses = $housesCount + 3;
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Лабораторна №8</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <h1>Лабораторна робота №8</h1>
  <p>Взаємодія користувача і сервера</p>
</header>

<main>

<h2 id="houses" style="text-align:center; margin-top:2rem;">Список будинків</h2>

<section class="products">
<?php foreach ($houses as $h): ?>
    <?php $sale = getDiscount(); ?>

    <div class="product">
        <img src="<?= htmlspecialchars($h->image) ?>" alt="<?= htmlspecialchars($h->name) ?>" class="product-image">

        <h2><?= htmlspecialchars($h->name) ?></h2>

        <?php if ($sale > 0): ?>
            <p><s><?= (float)$h->price ?>$</s></p>
            <p style="color:red; font-size:20px; font-weight:bold;">
                <?= (float)$h->price - ((float)$h->price * $sale / 100) ?>$ (−<?= (int)$sale ?>%)
            </p>
        <?php else: ?>
            <p><?= (float)$h->price ?>$</p>
        <?php endif; ?>

        <p><strong>Адреса:</strong> <?= htmlspecialchars($h->address) ?></p>
        <p><strong>Спальні:</strong> <?= (int)$h->beds ?> | <strong>Ванни:</strong> <?= (int)$h->baths ?></p>
        <p><strong>Телефон:</strong> <?= htmlspecialchars($h->phone) ?></p>
    </div>
<?php endforeach; ?>
</section>

<div style="text-align:center; margin: 20px 0;">
    <a href="?houses=<?= $nextHouses ?>#houses">
        <button type="button">Показати більше</button>
    </a>
</div>

<hr style="margin: 40px 0;">

<section id="contact" style="max-width: 700px; margin: 0 auto 40px auto;">
    <h2>Contact Me</h2>

    <form method="POST" action="#contact">
        <label>
            Ім'я:
            <input type="text" name="name" required value="<?= htmlspecialchars($_POST["name"] ?? "") ?>">
        </label>
        <br><br>

        <label>
            Email:
            <input type="email" name="email" required value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
        </label>
        <br><br>

        <label>
            Тема:
            <input type="text" name="subject" required value="<?= htmlspecialchars($_POST["subject"] ?? "") ?>">
        </label>
        <br><br>

        <label>
            Повідомлення:
            <textarea name="message" required rows="5"><?= htmlspecialchars($_POST["message"] ?? "") ?></textarea>
        </label>
        <br><br>

        <button type="submit">Submit</button>
    </form>

    <?php if (!empty($errors)): ?>
        <div style="color:red; margin-top: 15px;">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($contactObj !== null): ?>
        <h3 style="margin-top: 20px;">Отриманий об’єкт ContactInformation:</h3>
        <pre><?php print_r($contactObj); ?></pre>
    <?php endif; ?>
</section>

</main>

<footer>
    <p>Локація: Київ, Україна</p>
    <p>© <?= date("Y") ?> Всі права захищені</p>
</footer>

</body>
</html>
