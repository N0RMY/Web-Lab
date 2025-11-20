<?php
function findMaxMin($numbers) {
    return [
        "max" => max($numbers),
        "min" => min($numbers)
    ];
}

function extractEmails($text) {
    preg_match_all('/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}/i', $text, $matches);
    return $matches[0];
}

function sumNestedArray($array) {
    $sum = 0;
    foreach ($array as $value) {
        if (is_array($value)) {
            $sum += sumNestedArray($value);
        } elseif (is_numeric($value)) {
            $sum += $value;
        }
    }
    return $sum;
}

class Rectangle {
    private $width;
    private $height;

    public function __construct($w = null, $h = null) {
        if ($w) $this->setWidth($w);
        if ($h) $this->setHeight($h);
    }

    public function setWidth($width) {
        if ($width <= 0) throw new Exception("Ширина має бути > 0");
        $this->width = $width;
    }

    public function setHeight($height) {
        if ($height <= 0) throw new Exception("Висота має бути > 0");
        $this->height = $height;
    }

    public function calculateArea() {
        return $this->width * $this->height;
    }

    public function calculatePerimeter() {
        return 2 * ($this->width + $this->height);
    }
}

class Square extends Rectangle {
    public function __construct($side = null) {
        if ($side) $this->setSide($side);
    }

    public function setSide($side) {
        if ($side <= 0) throw new Exception("Сторона має бути > 0");
        $this->setWidth($side);
        $this->setHeight($side);
    }

    public function calculatePerimeter() {
        return 4 * $this->getWidth();
    }
}

interface Shape {
    public function calculateArea();
    public function calculatePerimeter();
}

class Circle implements Shape {
    private $radius;
    public function __construct($radius) {
        if ($radius <= 0) throw new Exception("Радіус має бути > 0");
        $this->radius = $radius;
    }
    public function calculateArea() {
        return round(pi() * $this->radius * $this->radius, 2);
    }
    public function calculatePerimeter() {
        return round(2 * pi() * $this->radius, 2);
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
<meta charset="UTF-8">
<title>Лабораторна робота №7</title>
<link rel="stylesheet" href="style.css">

</head>

<body>

<header>
    <h1>Лабораторна робота №7</h1>
    <p>Функції та об’єкти в PHP</p>
</header>

<main>

<div class="lab-container">

    <!-- Завдання 1 -->
    <div class="task-card">
        <h3>Завдання 1: Пошук Max & Min</h3>
        <p>Функція приймає масив чисел та повертає найбільше і найменше значення.</p>
        <input type="text" id="task1_input" placeholder="Наприклад: 3, 5, 1, 8, -2">
        <button onclick="task1()">Обчислити</button>
        <div class="result" id="task1_result"></div>
    </div>

    <!-- Завдання 2 -->
    <div class="task-card">
        <h3>Завдання 2: Виділення Email</h3>
        <p>Функція знаходить усі email-адреси у тексті за допомогою регулярних виразів.</p>
        <input type="text" id="task2_input" placeholder="admin@example.com, support@mail.ua">
        <button onclick="task2()">Знайти email</button>
        <div class="result" id="task2_result"></div>
    </div>

    <!-- Завдання 3 -->
    <div class="task-card">
        <h3>Завдання 3: Рекурсивна сума масиву</h3>
        <p>Функція знаходить суму елементів багатовимірного масиву (JSON формат).</p>
        <input type="text" id="task3_input" placeholder='[1,[2,3],[4,[5,6]]]' >
        <button onclick="task3()">Обчислити суму</button>
        <div class="result" id="task3_result"></div>
    </div>

    <!-- Завдання 4 -->
    <div class="task-card">
        <h3>Завдання 4: Клас Rectangle</h3>
        <p>Введи ширину та висоту — програма обчислює площу та периметр.</p>
        <input type="number" id="rect_w" placeholder="Ширина">
        <input type="number" id="rect_h" placeholder="Висота">
        <button onclick="task4()">Обчислити</button>
        <div class="result" id="task4_result"></div>
    </div>

    <!-- Завдання 5 -->
    <div class="task-card">
        <h3>Завдання 5: Клас Square</h3>
        <p>Квадрат задається лише стороною — обчислюється периметр.</p>
        <input type="number" id="sq_side" placeholder="Сторона квадрата">
        <button onclick="task5()">Обчислити</button>
        <div class="result" id="task5_result"></div>
    </div>

    <!-- Завдання 6 -->
    <div class="task-card">
        <h3>Завдання 6: Інтерфейси (Circle + Rectangle)</h3>
        <p>Обчислення площі та периметра кола й прямокутника.</p>
        <input type="number" id="circle_r" placeholder="Радіус кола">
        <input type="number" id="shape_w" placeholder="Ширина прямокутника">
        <input type="number" id="shape_h" placeholder="Висота прямокутника">
        <button onclick="task6()">Обчислити</button>
        <div class="result" id="task6_result"></div>
    </div>

</div>


    </div>

</div>
</main>

<footer>
    <p>© <?php echo date("Y"); ?> ElectroShop</p>
</footer>

</body>
</html>
