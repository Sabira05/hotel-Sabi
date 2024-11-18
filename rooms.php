<?php
session_start();

// Егер пайдаланушы жүйеге кірмеген болса
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Дерекқорға қосылу
$conn = new mysqli("localhost", "root", "", "hotel_booking");

if ($conn->connect_error) {
    die("Дерекқорға қосылу қатесі: " . $conn->connect_error);
}

// Бөлмелерді шығару
$sql = "SELECT rooms.room_type, 
               COUNT(rooms.room_type) - IFNULL(SUM(bookings.room_type = rooms.room_type), 0) AS available_rooms,
               CASE
                   WHEN rooms.room_type = 'standard' THEN 10000
                   WHEN rooms.room_type = 'luxury' THEN 20000
                   WHEN rooms.room_type = 'vip' THEN 30000
                   ELSE 0
               END AS room_price
        FROM rooms
        LEFT JOIN bookings ON rooms.room_type = bookings.room_type
        GROUP BY rooms.room_type";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <title>Бөлмелер мен брондау</title>
</head>
<body>
    <h1>Бөлмелер мен брондау</h1>

    <h2>Бөлмелер</h2>
    <ul>
    <?php while ($row = $result->fetch_assoc()): ?>
        <li>
            <?= ucfirst($row['room_type']) ?> бөлмесі
            <p>Бағасы: <?= number_format($row['room_price'], 2) ?> ₸</p>
            <a href="payment.php?room_type=<?= $row['room_type'] ?>&amount_paid=<?= $row['room_price'] ?>">Брондау</a>
        </li>
    <?php endwhile; ?>
</ul>

</body>
</html>

<?php
$conn->close();
?>
