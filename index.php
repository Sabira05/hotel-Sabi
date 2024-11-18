<?php
session_start();

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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,300&display=swap" rel="stylesheet"> <!-- Жіңішке, қисайған шрифт -->
    <style>
        /* Жалпы фон және мәтін стилі */
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif; /* Google Fonts шрифтін қосу */
            background: url('https://images7.alphacoders.com/362/362619.jpg') no-repeat center center fixed; /* Сурет фоны */
            background-size: cover; /* Фон суретін экранды толық жабатындай етіп жасау */
            color: white; /* Мәтіннің түсі ақ болады */
        }

        /* Басты бет тақырыбы */
        h1 {
            text-align: center;
            margin: 10;
            font-size: 2.5rem;
            font-weight: 300;
            color: #000; /* Түсті қара ету */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Көлеңке қосу */
        }

        /* Негізгі мәтін: алтын түсті, қисайған шрифт */
        .comfort-message {
            text-align: center;
            font-size: 2rem;
            font-weight: 300; /* Жіңішке шрифт */
            font-style: italic; /* Қисайған шрифт */
            margin-top: 0; /* Жоғарыдан арақашықтықты алып тастау */
            color: #000; /* Қара түсті орнату */
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5); /* Көлеңке қосу */
            letter-spacing: -0.5px; /* Мәтін арақашықтығын қысқарту */
        }

        /* Логотип стилі */
        .logo {
            width: 100px; /* Логотиптің ені */
            height: 100px; /* Логотиптің биіктігі */
            position: absolute;
            top: 20px;
            right: 20px; /* Оң жақ шетке орналастыру */
            border-radius: 50%; /* Логотипті дөңгелек етіп жасау */
            border: 2px solid #fff; /* Логотиптің айналасына ақ сызық қосу */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.3); /* Көлеңке қосу */
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
            width: 70%; /* Экранның 70%-ын алады */
            max-width: 300px;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8); /* Қара түсті мөлдір фон */
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
            background-color: #e74c3c;
            color: white;
            text-decoration: none;
            text-align: center;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            font-size: 1rem;
        }

        .menu-btn:hover {
            background-color: #c0392b;
        }
    </style>
    <script>
        // Мәзірді көрсету немесе жасыру
        function toggleMenu() {
            var menuOverlay = document.getElementById("menu-overlay");
            menuOverlay.style.display = (menuOverlay.style.display === "block") ? "none" : "block";
        }
    </script>
</head>
<body>

    <!-- Логотип -->
    <img src="hotel_logotip.png" alt="Қонақ үй логотипі" class="logo"> <!-- Логотип -->

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
        <a href="settings.php" class="menu-btn">Настройка</a>
        <a href="logout.php" class="menu-btn">Шығу</a>
    </div>

    <!-- Негізгі бет мазмұны -->
    <header>
        <div class="comfort-message">Біз сізге жайлылықты қамтамасыз етеміз!</div> <!-- Қара түсті қисайған мәтін -->
    </header>

</body>
</html>
