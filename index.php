<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ElectroShop</title>
  <link rel="stylesheet" href="style.css">
  <!-- Firebase SDKs -->
  <script type="module">
    // Імпортуємо потрібні модулі Firebase
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.1.0/firebase-app.js";
    import { getAnalytics, logEvent } from "https://www.gstatic.com/firebasejs/10.1.0/firebase-analytics.js";

    // Конфігурація Firebase
    const firebaseConfig = {
      apiKey: "AIzaSyALyC2-1a7Lk5VWnIf0JUPL26mRuC2icHs",
      authDomain: "electro-shop-5885d.firebaseapp.com",
      projectId: "electro-shop-5885d",
      storageBucket: "electro-shop-5885d.appspot.com",
      messagingSenderId: "765133533617",
      appId: "1:765133533617:web:efc37ebc3ba8a417000d90",
      measurementId: "G-6DWXQ49YBT"
    };

    // Ініціалізація Firebase
    const app = initializeApp(firebaseConfig);
    const analytics = getAnalytics(app);

    // Функція для логування подій
    window.trackButtonClick = (name) => {
      logEvent(analytics, 'button_click', { button_name: name });
      alert(`Натиснули кнопку: ${name}`);
    };
  </script>
<script src="main.js" type="module"></script>
</head>
<body>
  <header>
    <h1>ElectroShop</h1>
    <p>Ваш магазин електроніки онлайн</p>
  </header>

  <main>
    <section class="products">
      <div class="product">
        <img src="https://cdn.cosmos.so/349141b9-e93a-4ed3-82af-5df034aacced?format=jpeg" alt="Ноутбук" class="product-image">
        <h2>Ноутбук</h2>
        <p>Ціна: 25 000 ₴</p>
        <button onclick="trackButtonClick('Купити ноутбук')">Купити</button>
      </div>
      <div class="product">
        <img src="https://cdn.cosmos.so/ff30321d-4849-434d-9436-3937f3d5a88e?format=jpeg" alt="Смартфон" class="product-image">
        <h2>Смартфон</h2>
        <p>Ціна: 15 000 ₴</p>
        <button onclick="trackButtonClick('Купити смартфон')">Купити</button>
      </div>
      <div class="product">
        <img src="https://cdn.cosmos.so/47a37699-919c-4bce-abd9-b3467b7b7aea?format=jpeg" alt="Навушники" class="product-image">
        <h2>Навушники</h2>
        <p>Ціна: 2 500 ₴</p>
        <button onclick="trackButtonClick('Купити навушники')">Купити</button>
      </div>
  </main>

      <div style="margin-top:30px; text-align:center;">
    <a href="lab4.php">
      <button style="padding:10px 20px; font-size:16px; cursor:pointer;">
        Перейти до лабораторної роботи №4
      </button>
    </a>
  </div>

    <div style="margin-top:30px; text-align:center;">
    <a href="lab5.php">
      <button style="padding:10px 20px; font-size:16px; cursor:pointer;">
        Перейти до лабораторної роботи №5
      </button>
    </a>
  </div>

  <div style="margin-top:30px; text-align:center;">
    <a href="lab6.php">
      <button style="padding:10px 20px; font-size:16px; cursor:pointer;">
        Перейти до лабораторної роботи №6
      </button>
    </a>
  </div>

  <div style="margin-top:30px; text-align:center;">
    <a href="lab7.php">
      <button style="padding:10px 20px; font-size:16px; cursor:pointer;">
        Перейти до лабораторної роботи №7
      </button>
    </a>
  </div>

  <div style="margin-top:30px; text-align:center;">
    <a href="lab8.php">
      <button style="padding:10px 20px; font-size:16px; cursor:pointer;">
        Перейти до лабораторної роботи №8
      </button>
    </a>
  </div>
</div>





<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery UI -->
<link rel="stylesheet"
      href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<!-- Owl Carousel -->
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<!-- Твій скрипт -->
<script type="module" src="main.js"></script>

</body>
</html>



<footer>
    <p>© <?php echo date("Y"); ?> ElectroShop</p>
</footer>

</body>
</html>
