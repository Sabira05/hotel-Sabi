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
        .button-container {
            display: flex;
            justify-content: space-between; /* Батырмаларды екі жаққа орналастыру */
            gap: 10px;
        }
        button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        .login-button {
            background-color: green;
            color: white;
        }
        .login-button:hover {
            background-color: #219150;
        }
        .register-button {
            background-color: #007bff;
            color: white;
        }
        .register-button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="logo"><img src="hotel_logotip.png" alt="Логотип" class="logo"> </div>
    
    <?php if (isset($_SESSION["username"])): ?>
        <h3>Қош келдіңіз, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h3>
    <?php endif; ?>
    
    <form action="login.php" method="post">
        <label for="username">Пайдаланушы аты:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required>

        <div class="button-container">
            <button type="submit" class="login-button">Кіру</button>
            <button type="button" class="register-button" onclick="window.location.href='register1.html'">Тіркелу</button>
        </div>
    </form>
</body>
</html>
