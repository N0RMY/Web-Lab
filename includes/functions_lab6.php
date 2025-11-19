<?php

function getAboutBlock() {
    return '
        <section class="product" style="max-width:600px; margin:20px auto;">
            <h2>Про сайт (About)</h2>
            <p>Цей блок згенерований PHP-функцією.</p>
            <p>Він є частиною Лабораторної роботи №6.</p>
        </section>
    ';
}

function getDiscount() {
    return rand(0, 30);
}
