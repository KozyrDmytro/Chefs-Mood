<?php
require_once __DIR__ . '/../vendor/autoload.php';
session_start();

// Ініціалізація Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader);

// Завантаження мовного файлу
$lang = $_GET['lang'] ?? 'en';
require_once __DIR__ . "/../lang/{$lang}.php";

// Вивід головної сторінки
echo $twig->render('home.twig', [
    'title' => $lang_array['title'],
    'welcome' => $lang_array['welcome']
]);
