<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $roomType = $_POST['roomType'];

    $query = "SELECT * FROM rooms";
    if ($roomType !== 'all') {
        $query .= " WHERE type = :type";
    }
    $stmt = $pdo->prepare($query);

    if ($roomType !== 'all') {
        $stmt->bindParam(':type', $roomType);
    }
    $stmt->execute();
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $availableRooms = [];
    foreach ($rooms as $room) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE room_id = :room_id AND (checkin_date < :checkout AND checkout_date > :checkin)");
        $stmt->execute([':room_id' => $room['id'], ':checkin' => $checkin, ':checkout' => $checkout]);
        $booked = $stmt->fetchColumn();

        if ($booked == 0) {
            $availableRooms[] = $room;
        }
    }
    echo json_encode($availableRooms);
}
?>

