<?php
session_start();
require 'config.php'; // Дерекқорға қосылу үшін конфигурация файлы

// Пайдаланушы авторизациясын тексеру
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$user_data = [];

// Пайдаланушы мәліметтерін алу
$sql = "SELECT * FROM registration WHERE username = :username";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->execute();
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Пароль өзгерту
    if (isset($_POST['new_password'])) {
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];

        // Ескі паролді тексеру
        if (password_verify($old_password, $user_data['password'])) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            $update_sql = "UPDATE registration SET password = :password WHERE username = :username";
            $update_stmt = $pdo->prepare($update_sql);
            $update_stmt->bindParam(':password', $hashed_password);
            $update_stmt->bindParam(':username', $username);

            if ($update_stmt->execute()) {
                echo "Пароль сәтті өзгертілді!";
            } else {
                echo "Парольді өзгерту кезінде қате орын алды!";
            }
        } else {
            echo "Ескі пароль дұрыс емес!";
        }
    }

    // Сурет жүктеу
    if (isset($_FILES['photo'])) {
        $photo = $_FILES['photo'];

        if ($photo['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($photo['type'], $allowed_types)) {
                $upload_dir = 'uploads/';
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true); // Папканы жасау, егер жоқ болса
                }
                $file_path = $upload_dir . basename($photo['name']);
                if (move_uploaded_file($photo['tmp_name'], $file_path)) {
                    // Суретті дерекқорда сақтау
                    $update_sql = "UPDATE registration SET photo = :photo WHERE username = :username";
                    $update_stmt = $pdo->prepare($update_sql);
                    $update_stmt->bindParam(':photo', $file_path);
                    $update_stmt->bindParam(':username', $username);

                    if ($update_stmt->execute()) {
                        echo "Сурет сәтті жүктелді!";
                    } else {
                        echo "Қате орын алды!";
                    }
                } else {
                    echo "Сурет жүктелмеді!";
                }
            } else {
                echo "Қолдау көрсетілмейтін файл форматы!";
            }
        }
    }
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
    <form action="" method="POST">
        <label for="old_password">Ескі пароль:</label>
        <input type="password" id="old_password" name="old_password" required>

        <label for="new_password">Жаңа пароль:</label>
        <input type="password" id="new_password" name="new_password" required>

        <button type="submit">Өзгерту</button>
    </form>

    <h2>Сурет жүктеу</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="photo">Сурет:</label>
        <input type="file" id="photo" name="photo" accept="image/*" required>

        <button type="submit">Жүктеу</button>
    </form>

    <h2>Пайдаланушы мәліметтері</h2>
    <p><strong>Пайдаланушы аты:</strong> <?php echo $user_data['username']; ?></p>
    <p><strong>Электрондық пошта:</strong> <?php echo $user_data['email']; ?></p>
    <p><strong>Сурет:</strong> 
        <?php if (isset($user_data['photo'])): ?>
            <img src="<?php echo $user_data['photo']; ?>" alt="Пайдаланушы суреті" width="100">
        <?php else: ?>
            Сурет жоқ
        <?php endif; ?>
    </p>

    <a href="index.php">Басты бетке оралу</a>
</body>
</html>
