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
    <title>Настройка</title>
</head>
<body>
    <h1>Настройка</h1>

    <h2>Парольді өзгерту</h2>
    <form action="change_password.php" method="POST"> 
        <label for="old_password">Ескі пароль:</label>
        <input type="password" id="old_password" name="old_password" required>

        <label for="new_password">Жаңа пароль:</label>
        <input type="password" id="new_password" name="new_password" required>

        <button type="submit">Өзгерту</button>
    </form>

    <h2>Сурет жүктеу</h2>
    <form action="upload_photo.php" method="POST" enctype="multipart/form-data">
        <label for="photo">Сурет:</label>
        <input type="file" id="photo" name="photo" accept="image/*" required>

        <button type="submit">Жүктеу</button>
    </form>

    <a href="index.php">Басты бетке оралу</a>
</body>
</html>