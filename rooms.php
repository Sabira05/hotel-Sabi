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
    <title>Бөлме түрлері мен брондау</title>
</head>
<body>
    <h1>Бөлме түрлері</h1>
    <ul>
        <li>Стандартты бөлме - 10 000 ₸/түн</li>
        <li>Люкс бөлме - 20 000 ₸/түн</li>
        <li>VIP бөлме - 30 000 ₸/түн</li>
    </ul>

    <h2>Брондау</h2>
    <form action="booking.php" method="POST">
        <label for="name">Аты-жөніңіз:</label>
        <input type="text" id="name" name="name" required>

        <label for="checkin">Кіру күні:</label>
        <input type="date" id="checkin" name="checkin" required>

        <label for="checkout">Шығу күні:</label>
        <input type="date" id="checkout" name="checkout" required>

        <label for="room_type">Бөлме түрі:</label>
        <select id="room_type" name="room_type" required>
            <option value="standard">Стандартты бөлме</option>
            <option value="luxury">Люкс бөлме</option>
            <option value="vip">VIP бөлме</option>
        </select>

        <button type="submit">Брондау</button>
    </form>

    <a href="index.php">Басты бетке оралу</a>
</body>
</html>