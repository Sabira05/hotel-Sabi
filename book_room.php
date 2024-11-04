<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $room_id = $_POST['room_id'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];

    $stmt = $pdo->prepare("INSERT INTO bookings (user_id, room_id, checkin_date, checkout_date) VALUES (:user_id, :room_id, :checkin, :checkout)");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':room_id', $room_id);
    $stmt->bindParam(':checkin', $checkin);
    $stmt->bindParam(':checkout', $checkout);

    if ($stmt->execute()) {
        echo "Бөлме сәтті брондалды!";
    } else {
        echo "Қате: бөлме брондау мүмкін емес.";
    }
}
?>
