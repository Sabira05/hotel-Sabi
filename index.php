<?php
session_start(); // Сессияны бастау

// Егер сессияда 'username' айнымалысы болмаса, оны логин бетіне бағыттаймыз
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <title>Қонақ үй сайты</title>
    <link href="https://fonts.googleapis.com/css2?family=Times+New+Roman&display=swap" rel="stylesheet">
    <style>
        /* Жалпы фон және мәтін стилі */
        body {
            margin: 0;
            font-family: 'Times New Roman', serif; /* Барлық мәтіндер үшін Times New Roman шрифті */
            background: url('https://m.ahstatic.com/is/image/accorhotels/a5e1-1?qlt=82&wid=1920&ts=1710859451819&dpr=off') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }

        /* Басты бет тақырыбы */
        h1 {
            text-align: center;
            margin: 20px 0;
            font-size: 3rem;
            font-weight: 300;
            color: #fff;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.7);
        }

        /* Негізгі мәтін стилі */
        .comfort-message {
            position: fixed;
            bottom: 20px;
            width: 100%;
            text-align: center;
            font-size: 4rem;
            font-weight: 300;
            font-style: italic;
            color: #fff;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.7);
           
            letter-spacing: -0.5px;
        }

        /* Логотип стилі */
        .logo {
            width: 100px;
            height: 100px;
            position: absolute;
            top: 20px;
            right: 20px;
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.3);
        }

        /* Үш сызық мәзір белгісі */
        .menu-icon {
            position: absolute;
            top: 15px;
            left: 15px;
            cursor: pointer;
            z-index: 10;
        }

        .menu-icon div {
            width: 30px;
            height: 4px;
            background-color: #fff;
            margin: 6px 0;
            transition: all 0.3s ease;
        }

        /* Мәзірді жабатын бөлім */
        #menu-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 70%;
            max-width: 300px;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 20px;
            box-sizing: border-box;
            z-index: 9;
        }

        /* Мәзір батырмалары */
        .menu-btn {
            display: block;
            padding: 15px;
            margin: 10px 0;
            background-color: #FFE5CC;
            color: black;
            text-decoration: none;
            text-align: center;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            font-size: 1rem;
        }

        .menu-btn:hover {
            background-color: #c0392b;
        }

        /* Мәтінді төменге орналастыру */
        
    </style>
    <script>
        function toggleMenu() {
            var menuOverlay = document.getElementById("menu-overlay");
            menuOverlay.style.display = (menuOverlay.style.display === "block") ? "none" : "block";
        }
    </script>
</head>
<body>
    <!-- Логотип -->
    <img src="hotel_logotip.jpg" alt="Қонақ үй логотипі" class="logo">

    <!-- Пайдаланушыны қарсы алу -->
    <h1>Қош келдіңіз, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>

    <!-- Үш сызық мәзір белгісі -->
    <div class="menu-icon" onclick="toggleMenu()">
        <div></div>
        <div></div>
        <div></div>
    </div>

    <!-- Мәзір батырмалары орналасқан бөлім -->
    <div id="menu-overlay">
        <a href="rooms.php" class="menu-btn">Бөлмелер</a>
        <a href=".php" class="menu-btn">Біз туралы</a>
        <a href="settings.php" class="menu-btn">Настройка</a>
        <a href="logout.php" class="menu-btn">Шығу</a>
    </div>


    <!-- Төменгі мәтін -->
    <div class="comfort-message">Шексіз жайлылық, тамаша қонақжайлылық!</div>

</body>
</html>
