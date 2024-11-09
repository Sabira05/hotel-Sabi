<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>QyzPu Hotel</title>
  <style>
    /* Базовые стили для всех элементов на странице */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f9;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .container {
      width: 90%;
      max-width: 500px;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
      text-align: center;
    }

    /* Заголовок отеля */
    h1 {
      font-size: 24px;
      color: #333;
      margin-bottom: 20px;
    }

    /* Секция аутентификации */
    #authSection {
      margin-bottom: 20px;
    }

    #authSection label {
      display: block;
      text-align: left;
      margin-top: 10px;
      color: #666;
    }

    #authSection input[type="text"],
    #authSection input[type="password"] {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
    }

    #authSection button {
      width: 100%;
      padding: 10px;
      background-color: #4caf50;
      color: #fff;
      border: none;
      border-radius: 4px;
      font-size: 16px;
      cursor: pointer;
      margin-top: 15px;
    }

    #authSection a {
      display: block;
      margin-top: 10px;
      color: #4caf50;
      text-decoration: none;
      font-size: 14px;
    }

    #authSection a:hover {
      text-decoration: underline;
    }

    /* Секция бронирования */
    #bookingSection {
      margin-top: 20px;
    }

    #bookingSection label {
      display: block;
      text-align: left;
      margin-top: 10px;
      color: #666;
    }

    #bookingSection input[type="date"] {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
    }

    #bookingSection button {
      width: 100%;
      padding: 10px;
      background-color: #2196f3;
      color: #fff;
      border: none;
      border-radius: 4px;
      font-size: 16px;
      cursor: pointer;
      margin-top: 15px;
    }

    /* Список комнат */
    #roomList {
      margin-top: 20px;
      text-align: left;
    }

    .room-item {
      background-color: #f9f9f9;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      margin-bottom: 10px;
    }

    .room-item h3 {
      font-size: 18px;
      color: #333;
    }

    .room-item p {
      color: #666;
      margin: 5px 0;
    }

    .room-item button {
      padding: 8px 12px;
      background-color: #4caf50;
      color: #fff;
      border: none;
      border-radius: 4px;
      font-size: 14px;
      cursor: pointer;
    }

    .room-item button:hover {
      background-color: #45a049;
    }
  </style>
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
  </script>
</body>
</html>
