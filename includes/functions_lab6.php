<?php

// Завдання 3 — About блок
function getAboutBlock() {
    return '
        <section class="about">
            <h2>Про сайт (About)</h2>
            <p>Цей блок згенерований PHP-функцією.</p>
            <p>Він є частиною Лабораторної роботи №6.</p>
        </section>
    ';
}

// Завдання 8 — функція для знижки
function getDiscount() {
    return rand(0, 30); // 0–30%
}
