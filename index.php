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
    <style>
        /* Үш сызық мәзір белгісі */
        .menu-icon {
            cursor: pointer;
            width: 30px;
            display: inline-block;
        }
        .menu-icon div {
            width: 30px;
            height: 4px;
            background-color: black;
            margin: 6px 0;
        }

        /* Мәзірді жабатын бөлім */
        #menu-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 25%; /* Экранның 25%-ын алады */
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            color: white;
            padding: 20px;
            box-sizing: border-box;
        }

        /* Мәзір батырмалары */
        .menu-btn {
            display: block;
            padding: 10px;
            margin: 10px 0;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            text-align: center;
            border-radius: 5px;
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
        <img src="hotel.jpg" alt="Қонақ үй" style="width:100%; height:auto;">
        <h2>Қош келдіңіздер біздің қонақ үйге!</h2>
    </header>

</body>
</html>
