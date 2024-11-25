<?php
session_start();
require 'config.php'; // Дерекқор конфигурациясы

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Пайдаланушы аты мен құпия сөзді енгізіңіз.";
    } else {
        // Пайдаланушыны дерекқордан іздеу
        $stmt = $pdo->prepare("SELECT * FROM registration WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username']; // Сеансты бастау
            header("Location: index.php"); // Басты бетке бағыттау
            exit();
        } else {
            $error = "Қате: пайдаланушы аты немесе пароль дұрыс емес.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <title>Кіру</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url(https://m.ahstatic.com/is/image/accorhotels/aja_p_5629-25?qlt=82&wid=1920&ts=1710944159228&dpr=off) no-repeat center center fixed; /* Фонға сурет */
            background-size: cover;
            color: #6d4c41;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        form {
            background-color: rgba(255, 255, 255, 0.85); /* Ашық ақ фон */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 50px auto;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .button-container {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        button {
            background-color: #d8b894;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            width: 48%;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #b89e85;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <form action="login.php" method="post">
        <h2>Кіру</h2>
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <label for="username">Пайдаланушы аты:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required>

        <div class="button-container">
            <button type="submit">Кіру</button>
            <button type="button" onclick="window.location.href='register1.html'">Тіркелу</button>
        </div>
    </form>
</body>
</html>
