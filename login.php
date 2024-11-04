<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Пайдаланушы атының тексерісі
    if (empty($username) || empty($password)) {
        echo "Пайдаланушы аты мен құпия сөзді енгізіңіз.";
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        echo "Жүйеге сәтті кірдіңіз!";
    } else {
        echo "Қате: пайдаланушы аты немесе құпиясөз дұрыс емес.";
    }
}
?>
