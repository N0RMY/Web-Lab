<?php

// Завдання 3 — About блок
function getAboutBlock() {
    return '
        <section class="about">
            <h2>About</h2>
            <p>This is a PHP-generated block from Lab #6.</p>
            <p>Dynamic content, objects, and functions are used below.</p>
        </section>
    ';
}

// Завдання 8 — функція знижки
function getDiscount() {
    return rand(0, 30);
}
