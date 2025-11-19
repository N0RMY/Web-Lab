<!DOCTYPE html>
<html lang="uk">
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
  <h1>Лабораторна робота №4</h1>

  <div id="currentDate"></div>

<div>
  <h2>Останній день поточного місяця</h2>
  <p id="lastDay"></p>
</div>

  <div>
    <h2>Перевірка номера телефону</h2>
    <input type="text" id="phoneInput" placeholder="+38(XXX)XX-XX-XXX">
    <button onclick="checkPhoneNumber()">Check</button>
  </div>

  <div>
    <h2>Поміняти місцями ім’я та прізвище</h2>
    <input type="text" id="nameInput" placeholder="Прізвище Ім’я">
    <button onclick="swapName()">Swap</button>
  </div>

  <div>
    <h2>Цензура тексту</h2>
    <textarea id="textInput" placeholder="Введіть текст..."></textarea>
    <button onclick="censorText()">Censor</button>
    <p id="textOutput"></p>
  </div>