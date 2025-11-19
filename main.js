// ======== Поточна дата та час ========
function updateDateTime() {
  const el = document.getElementById("currentDate");
  if (el) {
    const now = new Date();
    const options = {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit'
    };
    el.textContent = now.toLocaleDateString('uk-UA', options);
  }
}

setInterval(updateDateTime, 1000);
updateDateTime();


// ======== Останній день місяця ========
window.addEventListener('DOMContentLoaded', () => {
  const lastDayElement = document.getElementById('lastDay');
  if (lastDayElement) {
    const now = new Date();
    const lastDay = new Date(now.getFullYear(), now.getMonth() + 1, 0).getDate();
    lastDayElement.textContent = `Останній день цього місяця: ${lastDay}`;
  }
});


// ======== Перевірка телефону ========
function checkPhoneNumber() {
  const phoneInput = document.getElementById('phoneInput').value;
  const phoneRegex = /^\+38\(\d{3}\)\d{2}-\d{2}-\d{3}$/;

  if (phoneRegex.test(phoneInput)) {
    alert(`Дякуємо! Ваш номер підтверджено: ${phoneInput}`);
  } else {
    alert('Невірний номер! Введіть у форматі +38(ХХХ)ХХ-ХХ-ХХХ');
  }
}


// ======== Зміна місцями ім’я/прізвище ========
function swapName() {
  const nameInput = document.getElementById('nameInput').value.trim();
  const parts = nameInput.split(/\s+/);
  if (parts.length >= 2) {
    alert(`Ваше ім’я і прізвище поміняно місцями: ${parts[1]} ${parts[0]}`);
  } else {
    alert('Введіть ім’я та прізвище через пробіл!');
  }
}


// ======== Цензор слів ========
const badWords = ['apple', 'orange', 'banana', 'pear', 'peach', 'grape', 'kiwi', 'mango', 'lemon', 'plum'];

function censorText() {
  let text = document.getElementById('textInput').value;
  let censored = text;

  badWords.forEach(word => {
    const regex = new RegExp(`\\b${word}\\b`, 'gi');
    censored = censored.replace(regex, '*'.repeat(word.length));
  });

  document.getElementById('textOutput').textContent = censored;
}


// ======== jQuery UI + OwlCarousel ========
$(document).ready(function () {

  // Кнопки show/hide
  $("#hideBtn").click(function () {
    $("#test").hide("slow");
  });

  $("#showBtn").click(function () {
    $("#test").show("slow");
  });

  // Accordion
  $("#accordion").accordion();

  // Datepicker
  $("#datepicker").datepicker();

  // Menu
  $("#menu").menu();

  // Slider
  $("#slider").slider({
    range: "min",
    value: 50,
    min: 0,
    max: 100,
    slide: function (event, ui) {
      $("#sliderValue").val(ui.value);
    }
  });
  $("#sliderValue").val($("#slider").slider("value"));

  // Tabs
  $("#tabs").tabs();

  // Tooltip
  $(".tooltip").tooltip();

  // OwlCarousel
  $(".owl-carousel").owlCarousel({
    loop: true,
    margin: 10,
    nav: true,
    responsive: {
      0: { items: 1 },
      600: { items: 3 },
      1000: { items: 5 }
    }
  });
});
