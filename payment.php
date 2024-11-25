<<<<<<< HEAD
=======
<?php
session_start();

// Пайдаланушының авторизацияланбаған жағдайда кіруге тыйым салу
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Бөлме түрлерінің бағалары
$room_prices = [
    'standard' => 10000,
    'deluxe' => 20000,
    'suite' => 30000,
];

// Параметрлерді алу
$room_type = $_GET['room_type'] ?? 'standard'; // Пайдаланушы таңдаған бөлме түрі
$checkin_date = $_GET['checkin_date'] ?? null;
$checkout_date = $_GET['checkout_date'] ?? null;

// Әр бөлме түрінің бағасын алу
$room_price_per_day = $room_prices[$room_type] ?? 0;

// Жалпы соманы есептеу
$total_days = 0;
$total_amount = 0;

if ($checkin_date && $checkout_date) {
    try {
        $checkin = new DateTime($checkin_date);
        $checkout = new DateTime($checkout_date);

        $interval = $checkin->diff($checkout);
        $total_days = max($interval->days, 0);

        if ($total_days > 0) {
            $total_amount = $total_days * $room_price_per_day;
        }
    } catch (Exception $e) {
        echo "Күндер дұрыс емес: " . $e->getMessage();
    }
}

// Дерекқорға қосылу
$conn = new mysqli("localhost", "root", "", "hotel_booking");

if ($conn->connect_error) {
    die("Дерекқорға қосылу қатесі: " . $conn->connect_error);
}

// Төлем сәтті жасалған жағдайда хабарлама көрсету және деректерді дерекқорға енгізу
$payment_success = false;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Карта мәліметтерін алу
    $card_number = $_POST['card_number'] ?? null;
    $card_expiry = $_POST['card_expiry'] ?? null;
    $card_cvv = $_POST['card_cvv'] ?? null;

    // Дерекқорға мәліметтерді енгізу
    if (!empty($card_number) && !empty($card_expiry) && !empty($card_cvv)) {
        // SQL сұрауын дайындау
        $stmt = $conn->prepare("INSERT INTO payment (room_type, amount_paid, card_number, card_expiry, card_cvv, checkin_date, checkout_date) VALUES (?, ?, ?, ?, ?, ?, ?)");

        if ($stmt === false) {
            die('SQL сұрауы қатесі: ' . $conn->error);
        }

        // Параметрлерді байлау
        $stmt->bind_param("sssssss", $room_type, $total_amount, $card_number, $card_expiry, $card_cvv, $checkin_date, $checkout_date);

        // Сұрауды орындау
        if ($stmt->execute()) {
            $payment_success = true;
        } else {
            echo "Қате: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

>>>>>>> 77e0996c40340ab97e3992d38e610d1770eab8f4
<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <title>Төлем жасау</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 90%;
            max-width: 600px;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            overflow: hidden;
            padding: 20px;
            text-align: center;
        }

        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        form {
            text-align: left;
        }

        label {
            font-size: 16px;
            color: #555;
            display: block;
            margin: 10px 0 5px;
        }

        select, input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #d8c3a5; /* Бежевый түс */
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #c3ac8f;
        }

        .info {
            margin-top: 15px;
            font-size: 16px;
            text-align: center;
        }

        .total-amount {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #d8c3a5;
        }

        .back-to-home {
            margin-top: 20px;
            display: block;
            padding: 10px 20px;
            background-color: #d8c3a5; /* Бежевый түс */
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .back-to-home:hover {
            background-color: #c3ac8f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Төлем жасау</h1>

<<<<<<< HEAD
        <form action="" method="GET">
            <label for="room_type" style="text-align: center;">Бөлме түрі:</label>
            <select id="room_type" name="room_type">
                <option value="standard">Standard</option>
                <option value="Luxury">Luxury</option>
                <option value="Vip">Vip</option>
            </select>

            <label for="checkin_date" style="text-align: center;">Кіру күні:</label>
            <input type="date" id="checkin_date" name="checkin_date" required>
=======
    <form action="" method="GET">
        <label for="room_type">Бөлме түрі:</label>
        <select id="room_type" name="room_type">
            <option value="standard" <?= $room_type === 'standard' ? 'selected' : '' ?>>Standard</option>
            <option value="deluxe" <?= $room_type === 'deluxe' ? 'selected' : '' ?>>Deluxe</option>
            <option value="suite" <?= $room_type === 'suite' ? 'selected' : '' ?>>Suite</option>
        </select>

        <label for="checkin_date">Кіру күні:</label>
        <input type="date" id="checkin_date" name="checkin_date" value="<?= htmlspecialchars($checkin_date) ?>" required>
>>>>>>> 77e0996c40340ab97e3992d38e610d1770eab8f4

            <label for="checkout_date" style="text-align: center;">Шығу күні:</label>
            <input type="date" id="checkout_date" name="checkout_date" required>

            <button type="submit">Соманы есептеу</button>
        </form>

<<<<<<< HEAD
        <div class="info">
            Сіз таңдаған бөлме түрі: <strong>Standard</strong><br>
            Күніне бағасы: <strong>10,000 ₸</strong><br>
            Тұру ұзақтығы: <strong>3 күн</strong><br>
        </div>
=======
    <p>Сіз таңдаған бөлме түрі: <?= ucfirst($room_type) ?></p>
    <p>Күніне бағасы: <?= number_format($room_price_per_day, 2) ?> ₸</p>
    <p>Тұру ұзақтығы: <?= $total_days ?> күн</p>
    <div class="total-amount">Жалпы сомасы: <?= number_format($total_amount, 2) ?> ₸</div>

    <!-- Төлем жасау -->
    <form action="" method="POST" class="payment-form">
        <input type="hidden" name="room_type" value="<?= htmlspecialchars($room_type) ?>">
        <input type="hidden" name="amount_paid" value="<?= htmlspecialchars($total_amount) ?>">
        <input type="hidden" name="checkin_date" value="<?= htmlspecialchars($checkin_date) ?>">
        <input type="hidden" name="checkout_date" value="<?= htmlspecialchars($checkout_date) ?>">
>>>>>>> 77e0996c40340ab97e3992d38e610d1770eab8f4

        <div class="total-amount">Жалпы сомасы: 30,000 ₸</div>

        <form action="" method="POST">
            <label for="card_number">Карта нөмірі:</label>
            <input type="text" id="card_number" name="card_number" maxlength="16" required>

            <label for="card_expiry">Жарамдылық мерзімі:</label>
            <input type="month" id="card_expiry" name="card_expiry" required>

            <label for="card_cvv">CVV:</label>
            <input type="text" id="card_cvv" name="card_cvv" maxlength="3" required>

            <button type="submit">Төлеу</button>
        </form>

<<<<<<< HEAD
        <a href="index.php" class="back-to-home">Басты бетке оралу</a>
    </div>
=======
    <!-- Басты бетке өту кнопкасы -->
    <a href="index.php" class="back-to-home">Басты бетке оралу</a>
>>>>>>> 77e0996c40340ab97e3992d38e610d1770eab8f4
</body>
</html>
