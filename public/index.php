<?php
session_start();
require_once __DIR__ . '/../src/twig.php';

// Визначення мови
$lang = $_GET['lang'] ?? ($_SESSION['lang'] ?? 'en');
$_SESSION['lang'] = $lang;

// Завантаження мовного масиву
$langFile = __DIR__ . '/../lang/' . $lang . '.php';
if (file_exists($langFile)) {
    require_once $langFile;
} else {
    require_once __DIR__ . '/../lang/en.php';
}

// Визначення сторінки (маршрутизація)
$page = $_GET['page'] ?? 'home';
$template = $page . '.twig';

// Підготовка Twig
$twig = getTwig();

// Перевірка наявності шаблону
$templatePath = __DIR__ . '/../src/templates/' . $template;
if (!file_exists($templatePath)) {
    http_response_code(404);
    echo $twig->render('404.twig', ['title' => '404', 'message' => 'Сторінку не знайдено']);
    exit;
}

// Вивід потрібної сторінки
echo $twig->render($template, [
    'title' => $lang_array['title'] ?? 'Chef\'s Mood',
    'welcome' => $lang_array['welcome'] ?? '',
    'lang' => $lang
]);
