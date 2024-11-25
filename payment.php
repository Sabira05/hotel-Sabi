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
    $card_expiry_month = $_POST['card_expiry_month'] ?? null;
    $card_expiry_year = $_POST['card_expiry_year'] ?? null;
    $card_cvv = $_POST['card_cvv'] ?? null;

    // Дерекқорға мәліметтерді енгізу
    if (!empty($card_number) && !empty($card_expiry_month) && !empty($card_expiry_year) && !empty($card_cvv)) {
        // SQL сұрауын дайындау
        $stmt = $conn->prepare("INSERT INTO payment (room_type, amount_paid, card_number, card_expiry, card_cvv, checkin_date, checkout_date) VALUES (?, ?, ?, ?, ?, ?, ?)");

        if ($stmt === false) {
            die('SQL сұрауы қатесі: ' . $conn->error);
        }

        // Параметрлерді байлау
        $card_expiry = $card_expiry_month . '/' . $card_expiry_year;
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
            background: rgba(255, 255, 255, 0.9); /* Ақ түс, мөлдірлік */
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
        <form action="" method="POST">
            <label for="room_type">Бөлме түрі:</label>
            <select id="room_type" name="room_type">
                <option value="standard" <?php echo $room_type == 'standard' ? 'selected' : ''; ?>>Standard</option>
                <option value="deluxe" <?php echo $room_type == 'deluxe' ? 'selected' : ''; ?>>Deluxe</option>
                <option value="suite" <?php echo $room_type == 'suite' ? 'selected' : ''; ?>>Suite</option>
            </select>

            <label for="checkin_date">Кіру күні:</label>
            <input type="date" id="checkin_date" name="checkin_date" value="<?php echo $checkin_date; ?>" required>

            <label for="checkout_date">Шығу күні:</label>
            <input type="date" id="checkout_date" name="checkout_date" value="<?php echo $checkout_date; ?>" required>

            <div class="total-amount">
                <?php if ($total_days > 0 && $total_amount > 0): ?>
                    <p>Жалпы сомасы: <?php echo number_format($total_amount, 0, '.', ' ') ?> тг</p>
                <?php endif; ?>
            </div>

            <label for="card_number">Карта нөмірі:</label>
            <input type="text" id="card_number" name="card_number" required>

            <label for="card_expiry">Карта мерзімі (ММ/ЖЖ):</label>
            <div style="display: flex; justify-content: space-between;">
                <select id="card_expiry_month" name="card_expiry_month" required>
                    <option value="">Ай</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>

                <select id="card_expiry_year" name="card_expiry_year" required>
                    <option value="">Жыл</option>
                    <?php
                    // Қазіргі жыл мен келесі 10 жылды көрсету
                    $current_year = date("Y");
                    for ($i = 0; $i < 11; $i++) {
                        $year = $current_year + $i;
                        echo "<option value='$year'>$year</option>";
                    }
                    ?>
                </select>
            </div>

            <label for="card_cvv">Карта CVV:</label>
            <input type="text" id="card_cvv" name="card_cvv" required>

            <button type="submit">Төлемді аяқтау</button>
        </form>

        <?php if ($payment_success): ?>
            <div class="info">
                <p>Төлем сәтті жасалды!</p>
                <a href="index.php" class="back-to-home">Басты бетке қайту</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
