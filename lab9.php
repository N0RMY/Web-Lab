<?php
require_once __DIR__ . "/includes/helpers.php";

// контролери (логіка)
require_once __DIR__ . "/includes/houses_controller.php";
require_once __DIR__ . "/includes/contact_controller.php";
?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Лабораторна №9</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <h1>Лабораторна робота №9</h1>
  <p>Взаємодія користувача і сервера</p>
</header>

<main>

<h2 id="houses" style="text-align:center; margin-top:2rem;">Список будинків</h2>

<section class="products">
  <?php foreach ($houses as $h): ?>
    <?php $sale = function_exists("getDiscount") ? getDiscount() : 0; ?>
    <div class="product">
      <img src="<?= h($h->image) ?>" alt="<?= h($h->name) ?>" class="product-image">
      <h2><?= h($h->name) ?></h2>

      <?php if ($sale > 0): ?>
        <p><s><?= (float)$h->price ?>$</s></p>
        <p style="color:red; font-size:20px; font-weight:bold;">
          <?= (float)$h->price - ((float)$h->price * $sale / 100) ?>$ (−<?= (int)$sale ?>%)
        </p>
      <?php else: ?>
        <p><?= (float)$h->price ?>$</p>
      <?php endif; ?>

      <p><strong>Адреса:</strong> <?= h($h->address) ?></p>
      <p><strong>Спальні:</strong> <?= (int)$h->beds ?> | <strong>Ванни:</strong> <?= (int)$h->baths ?></p>
      <p><strong>Телефон:</strong> <?= h($h->phone) ?></p>
    </div>
  <?php endforeach; ?>
</section>

<div style="text-align:center; margin: 20px 0;">
  <a href="<?= h($showLessLink) ?>"><button type="button">Показати менше</button></a>
  <a href="<?= h($showMoreLink) ?>"><button type="button">Показати більше</button></a>
</div>

<hr style="margin: 40px 0;">

<section id="contact" style="max-width: 700px; margin: 0 auto 40px auto;">
  <h2>Contact Me</h2>

  <form method="POST" action="#contact">
    <label>
      Ім'я:
      <input id="firstField" type="text" name="name" required value="<?= h($form["name"]) ?>">
    </label>
    <br><br>

    <label>
      Email:
      <input type="text" name="email" required value="<?= h($form["email"]) ?>">
    </label>
    <br><br>

    <label>
      Дата народження:
      <input type="date" name="birth_date" required value="<?= h($form["birth_date"]) ?>">
    </label>
    <br><br>

    <label>
      Тема:
      <input type="text" name="subject" required value="<?= h($form["subject"]) ?>">
    </label>
    <br><br>

    <label>
      Повідомлення:
      <textarea name="message" required rows="5"><?= h($form["message"]) ?></textarea>
    </label>
    <br><br>

    <button type="submit" name="submit" value="1">Submit</button>
    <button type="submit" name="clear" value="1">Очистити форму</button>
  </form>

  <?php if ($errors): ?>
    <div style="color:red; margin-top: 15px;">
      <ul>
        <?php foreach ($errors as $e): ?>
          <li><?= h($e) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <?php if ($contactObj !== null): ?>
    <h3 style="margin-top: 20px;">Об’єкт ContactInformation (pre):</h3>
    <pre><?php print_r($contactObj); ?></pre>

    <p><strong>Середня довжина даних у формі:</strong> <?= number_format((float)$avgLen, 2) ?> символів</p>

    <h3>Дані у вигляді таблиці:</h3>
    <?= $contactObj->toHtmlTable(); ?>
  <?php endif; ?>
</section>

<?php if ($shouldFocusFirst): ?>
<script>
  window.addEventListener("load", () => {
    const el = document.getElementById("firstField");
    if (el) el.focus();
  });
</script>
<?php endif; ?>

</main>

<footer>
  <p>Локація: Київ, Україна</p>
  <p>© <?= date("Y") ?> Всі права захищені</p>
</footer>

</body>
</html>
