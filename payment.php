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

        <form action="" method="GET">
            <label for="room_type" style="text-align: center;">Бөлме түрі:</label>
            <select id="room_type" name="room_type">
                <option value="standard">Standard</option>
                <option value="Luxury">Luxury</option>
                <option value="Vip">Vip</option>
            </select>

            <label for="checkin_date" style="text-align: center;">Кіру күні:</label>
            <input type="date" id="checkin_date" name="checkin_date" required>

            <label for="checkout_date" style="text-align: center;">Шығу күні:</label>
            <input type="date" id="checkout_date" name="checkout_date" required>

            <button type="submit">Соманы есептеу</button>
        </form>

        <div class="info">
            Сіз таңдаған бөлме түрі: <strong>Standard</strong><br>
            Күніне бағасы: <strong>10,000 ₸</strong><br>
            Тұру ұзақтығы: <strong>3 күн</strong><br>
        </div>

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

        <a href="index.php" class="back-to-home">Басты бетке оралу</a>
    </div>
</body>
</html>
