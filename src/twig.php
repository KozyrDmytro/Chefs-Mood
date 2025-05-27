<?php
require_once __DIR__ . '/../vendor/autoload.php';

function getTwig(): \Twig\Environment {
    $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
    $twig = new \Twig\Environment($loader, [
        'cache' => __DIR__ . '/../storage/cache',
        'auto_reload' => true
    ]);
    return $twig;
}