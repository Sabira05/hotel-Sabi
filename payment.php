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
$room_type = 'standard'; // Тұрақты бөлме түрі
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

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <title>Төлем беті</title>
    <style>
        .total-amount {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }

        .payment-success {
            margin-top: 20px;
            font-size: 16px;
            color: green;
            text-align: right;
        }

        .payment-form label {
            display: block;
            margin-top: 10px;
        }

        .back-to-home {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        .back-to-home:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Төлем жасау</h1>

    <p>Сіз таңдаған бөлме түрі: Standard</p>
    <p>Күніне бағасы: <?= number_format($room_price_per_day, 2) ?> ₸</p>
    <p>Тұру ұзақтығы: <?= $total_days ?> күн</p>
    <div class="total-amount">Жалпы сомасы: <?= number_format($total_amount, 2) ?> ₸</div>

    <!-- Соманы есептеу -->
    <form action="" method="GET">
        <label for="checkin_date">Кіру күні:</label>
        <input type="date" id="checkin_date" name="checkin_date" value="<?= htmlspecialchars($checkin_date) ?>" required>

        <label for="checkout_date">Шығу күні:</label>
        <input type="date" id="checkout_date" name="checkout_date" value="<?= htmlspecialchars($checkout_date) ?>" required>

        <button type="submit">Соманы есептеу</button>
    </form>

    <!-- Төлем жасау -->
    <form action="" method="POST" class="payment-form">
        <input type="hidden" name="room_type" value="<?= htmlspecialchars($room_type) ?>">
        <input type="hidden" name="amount_paid" value="<?= htmlspecialchars($total_amount) ?>">
        <input type="hidden" name="checkin_date" value="<?= htmlspecialchars($checkin_date) ?>">
        <input type="hidden" name="checkout_date" value="<?= htmlspecialchars($checkout_date) ?>">

        <label for="card_number">Карта нөмірі:</label>
        <input type="text" id="card_number" name="card_number" maxlength="16" required>

        <label for="card_expiry">Жарамдылық мерзімі:</label>
        <input type="month" id="card_expiry" name="card_expiry" required>

        <label for="card_cvv">CVV:</label>
        <input type="text" id="card_cvv" name="card_cvv" maxlength="3" required>

        <button type="submit">Төлеу</button>
    </form>

    <!-- Төлем сәтті орындалды -->
    <?php if ($payment_success): ?>
        <div class="payment-success">Төлем сәтті орындалды!</div>
    <?php endif; ?>

    <!-- Басты бетке өту кнопкасы -->
    <a href="index.php">Басты бетке оралу</a>
</body>
</html>
