<?php
session_start();
require 'config.php'; // config.php арқылы дерекқорға қосылу

// Логин формасы жіберілгенін тексеру
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Пайдаланушы аты мен құпия сөзді тексеру
    if (empty($username) || empty($password)) {
        echo "<div class='error'>Пайдаланушы аты мен құпия сөзді енгізіңіз.</div>";
        exit;
    }

    // Пайдаланушыны табу
    $stmt = $pdo->prepare("SELECT * FROM registration WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        header("Location: index.php"); // Сәтті логин болса, басты бетке бағыттау
        exit();
    } else {
        echo "<div class='error'>Қате: пайдаланушы аты немесе пароль дұрыс емес.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <title>Кіру</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8; /* Жеңіл көкшіл фон */
            color: #2c3e50;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        .logo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #27ae60;
            margin: 20px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: green;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #219150;
        }
        .error {
            color: red;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="logo">Логотип</div>
    
    <?php if (isset($_SESSION["username"])): ?>
        <h3>Қош келдіңіз, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h3>
    <?php endif; ?>
    
    <form action="login.php" method="post">
        <label for="username">Пайдаланушы аты:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Кіру</button>
    </form>
</body>
</html>
