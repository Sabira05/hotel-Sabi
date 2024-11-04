<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>QyzPu Hotel</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>QyzPu Hotel</h1>

    <div id="authSection">
      <form id="authForm" method="POST" action="login.php">
        <label for="username">Пайдаланушы аты:</label>
        <input type="text" name="username" required>
        <label for="password">Құпиясөз:</label>
        <input type="password" name="password" required>
        <button type="submit">Кіру</button>
      </form>
      <a href="register.php">Тіркелу</a>
    </div>

    <div id="bookingSection" style="display: none;">
      <form id="bookingForm" method="POST" action="search_rooms.php">
        <label for="checkin">Кіру күні:</label>
        <input type="date" id="checkin" required>
        <label for="checkout">Шығу күні:</label>
        <input type="date" id="checkout" required>
        <button type="button" onclick="searchRooms()">Іздеу</button>
      </form>
      <div id="roomList"></div>
    </div>
  </div>

  <script>
    function searchRooms() {
      const checkin = document.getElementById("checkin").value;
      const checkout = document.getElementById("checkout").value;

      fetch("search_rooms.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `checkin=${checkin}&checkout=${checkout}`
      })
      .then(response => response.json())
      .then(data => {
        const roomList = document.getElementById("roomList");
        roomList.innerHTML = "";

        data.forEach(room => {
          roomList.innerHTML += `
            <div class="room-item">
              <h3>${room.type} бөлмесі</h3>
              <p>Бағасы: $${room.price}</p>
              <button onclick="bookRoom(${room.id})">Брондау</button>
            </div>
          `;
        });
      });
    }

