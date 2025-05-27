<?php
session_start();
require_once __DIR__ . '/../../src/twig.php';

$twig = getTwig();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $usersFile = __DIR__ . '/../../storage/users.json';
    $users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

    if (!isset($users[$email]) || !password_verify($password, $users[$email]['password'])) {
        echo $twig->render('login.twig', ['error' => 'Невірний email або пароль']);
        exit;
    }

    $_SESSION['email'] = $email;
    $_SESSION['role'] = $users[$email]['role'];

    header('Location: /?page=home');
    exit;
} else {
    echo $twig->render('login.twig');
}
