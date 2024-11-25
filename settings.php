<?php
session_start();
require 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$user_data = [];

$sql = "SELECT * FROM registration WHERE username = :username";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->execute();
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

$update_message = ''; // Хабарлама айнымалысы

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['new_password'])) {
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];

        if (password_verify($old_password, $user_data['password'])) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            $update_sql = "UPDATE registration SET password = :password WHERE username = :username";
            $update_stmt = $pdo->prepare($update_sql);
            $update_stmt->bindParam(':password', $hashed_password);
            $update_stmt->bindParam(':username', $username);

            if ($update_stmt->execute()) {
                $update_message = 'Пароль сәтті өзгертілді!';
            } else {
                $update_message = 'Парольді өзгерту кезінде қате орын алды!';
            }
        } else {
            $update_message = 'Ескі пароль дұрыс емес!';
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
                    mkdir($upload_dir, 0777, true);
                }
                $file_path = $upload_dir . basename($photo['name']);
                if (move_uploaded_file($photo['tmp_name'], $file_path)) {
                    $update_sql = "UPDATE registration SET photo = :photo WHERE username = :username";
                    $update_stmt = $pdo->prepare($update_sql);
                    $update_stmt->bindParam(':photo', $file_path);
                    $update_stmt->bindParam(':username', $username);

                    if ($update_stmt->execute()) {
                        $update_message = 'Сурет сәтті жүктелді!';
                    } else {
                        $update_message = 'Қате орын алды!';
                    }
                } else {
                    $update_message = 'Сурет жүктелмеді!';
                }
            } else {
                $update_message = 'Қолдау көрсетілмейтін файл форматы!';
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
    <style>
        body {
            margin: 0;
            font-family: 'Times New Roman', Times, serif;
            background-image: url('https://m.ahstatic.com/is/image/accorhotels/aja_p_5484-69?qlt=82&wid=1920&ts=1710869809079&dpr=off');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
            padding: 20px;
        }

        .container {
            width: 50%;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            text-align: left;
            color: #333;
            font-size: 1.25rem;
            font-weight: 400;
            margin-bottom: 1rem;
        }

        form {
            display: flex;
            flex-direction: column;
            margin: 1.5rem 0;
        }

        form label {
            font-size: 0.9rem;
            margin-bottom: 5px;
            text-align: left;
        }

        form input {
            padding: 6px;
            font-size: 0.9rem;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            width: 100%;
            max-width: 300px;
        }

        form button {
            padding: 6px 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 15%;
            margin: 5px;
        }

        form button:hover {
            background-color: #45a049;
        }

        .message {
            padding: 10px;
            margin-bottom: 20px;
            background-color: #f0f8ff;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            color: #333;
        }

        .photo img {
            width: 250px;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
        }

        a {
            display: block;
            text-align: left;
            margin-top: 20px;
            font-size: 0.9rem;
            text-decoration: none;
            color: #007BFF;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Настройка</h1>

        <?php if ($update_message != ''): ?>
            <div class="message"><?php echo $update_message; ?></div>
        <?php endif; ?>

        <h2></h2>
        <div class="photo">
            <?php if (isset($user_data['photo']) && !empty($user_data['photo'])): ?>
                <img src="<?php echo $user_data['photo']; ?>" alt="Пайдаланушы суреті">
            <?php else: ?>
                <p>Сурет жоқ</p>
            <?php endif; ?>
        </div>

        <h2>Пайдаланушы мәліметтері</h2>
        <p><strong>Пайдаланушы аты:</strong> <?php echo isset($user_data['username']) ? $user_data['username'] : 'Мәлімет жоқ'; ?></p>
        <p><strong>Электрондық пошта:</strong> <?php echo isset($user_data['email']) ? $user_data['email'] : 'Мәлімет жоқ'; ?></p>

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

        <a href="index.php">Басты бетке оралу</a>
    </div>

</body>
</html>