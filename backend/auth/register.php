<?php
session_start();
require_once __DIR__ . '/../../src/twig.php';

$twig = getTwig();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if ($password !== $confirm) {
        echo $twig->render('register.twig', ['error' => 'Паролі не співпадають']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo $twig->render('register.twig', ['error' => 'Некоректний email']);
        exit;
    }

    $usersFile = __DIR__ . '/../../storage/users.json';
    $users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

    if (isset($users[$email])) {
        echo $twig->render('register.twig', ['error' => 'Користувач вже існує']);
        exit;
    }

    $users[$email] = [
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'role' => 'user'
    ];

    file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));

    $_SESSION['email'] = $email;
    $_SESSION['role'] = 'user';

    header('Location: /?page=home');
    exit;
} else {
    echo $twig->render('register.twig');
}
