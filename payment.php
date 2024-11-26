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
$room_type = $_GET['room_type'] ?? 'standard';
$checkin_date = $_GET['checkin_date'] ?? null;
$checkout_date = $_GET['checkout_date'] ?? null;

// Жалпы соманы есептеу
$room_price_per_day = $room_prices[$room_type] ?? 0;
$total_days = 0;
$total_amount = 0;

if (!empty($checkin_date) && !empty($checkout_date)) {
    try {
        $checkin = new DateTime($checkin_date);
        $checkout = new DateTime($checkout_date);

        if ($checkout > $checkin) {
            $interval = $checkin->diff($checkout);
            $total_days = $interval->days;
            $total_amount = $total_days * $room_price_per_day;
        } else {
            $error_message = "Шығу күні кіру күнінен кейін болуы керек.";
        }
    } catch (Exception $e) {
        $error_message = "Күндер дұрыс емес: " . $e->getMessage();
    }
}

// Дерекқорға қосылу
$conn = new mysqli("localhost", "root", "", "hotel_booking");
if ($conn->connect_error) {
    die("Дерекқорға қосылу қатесі: " . $conn->connect_error);
}

// Төлем жасау
$payment_success = false;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $card_number = $_POST['card_number'] ?? null;
    $card_expiry_month = $_POST['card_expiry_month'] ?? null;
    $card_expiry_year = $_POST['card_expiry_year'] ?? null;
    $card_cvv = $_POST['card_cvv'] ?? null;

    if (!empty($card_number) && !empty($card_expiry_month) && !empty($card_expiry_year) && !empty($card_cvv)) {
        $stmt = $conn->prepare("INSERT INTO payment (room_type, amount_paid, card_number, card_expiry, card_cvv, checkin_date, checkout_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die('SQL қатесі: ' . $conn->error);
        }

        $card_expiry = $card_expiry_month . '/' . $card_expiry_year;
        $stmt->bind_param("sssssss", $room_type, $total_amount, $card_number, $card_expiry, $card_cvv, $checkin_date, $checkout_date);

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
<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Төлем жасау</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: url('https://m.ahstatic.com/is/image/accorhotels/aja_p_5553-45?qlt=82&wid=1920&ts=1729248820030&dpr=off');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .container {
            width: 90%;
            max-width: 600px;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
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
            width: 90%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #d8c3a5;
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
            background-color: #d8c3a5;
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
        <form method="GET">
            <label for="room_type">Бөлме түрі:</label>
            <select id="room_type" name="room_type">
                <option value="standard" <?= $room_type == 'standard' ? 'selected' : '' ?>>Standard</option>
                <option value="deluxe" <?= $room_type == 'deluxe' ? 'selected' : '' ?>>Deluxe</option>
                <option value="suite" <?= $room_type == 'suite' ? 'selected' : '' ?>>Suite</option>
            </select>

            <label for="checkin_date">Кіру күні:</label>
            <input type="date" id="checkin_date" name="checkin_date" value="<?= $checkin_date ?>" required>

            <label for="checkout_date">Шығу күні:</label>
            <input type="date" id="checkout_date" name="checkout_date" value="<?= $checkout_date ?>" required>

            <button type="submit">Соманы есептеу</button>
        </form>

        <?php if ($total_amount > 0): ?>
            <div class="total-amount">Жалпы сома: <?= $total_amount ?> ₸</div>
            <form method="POST">
                <label for="card_number">Карта нөмірі:</label>
                <input 
                    type="text" 
                    id="card_number" 
                    name="card_number" 
                    maxlength="16" 
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)" 
                    required>

                <label for="card_expiry_month">Карта мерзімі (ай):</label>
                <input 
                    type="number" 
                    id="card_expiry_month" 
                    name="card_expiry_month" 
                    min="1" 
                    max="12" 
                    oninput="if(this.value > 12) this.value = 12; if(this.value < 1) this.value = 1;" 
                    required>

                <label for="card_expiry_year">Карта мерзімі (жыл):</label>
                <input 
                    type="number" 
                    id="card_expiry_year" 
                    name="card_expiry_year" 
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4)" 
                    required>

                <label for="card_cvv">CVV:</label>
                <input 
                    type="password" 
                    id="card_cvv" 
                    name="card_cvv" 
                    maxlength="3" 
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3)" 
                    required>

                <button type="submit">Төлеу</button>
            </form>
        <?php endif; ?>

        <?php if ($payment_success): ?>
            <div class="info">Төлем сәтті жасалды!</div>
            <?php endif; ?>

            <a href="index.php" class="back-to-home">Басты бетке қайту</a>
