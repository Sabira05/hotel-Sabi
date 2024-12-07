<?php
session_start();

// Сессияны тексеру
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
$sql = "SELECT room_type, COUNT(*) - SUM(CASE WHEN bookings.room_type IS NOT NULL THEN 1 ELSE 0 END) AS available_rooms, 
        CASE 
            WHEN room_type = 'standard' THEN 10000 
            WHEN room_type = 'luxury' THEN 20000 
            WHEN room_type = 'vip' THEN 30000 
        END AS room_price 
        FROM rooms 
        LEFT JOIN bookings ON rooms.room_type = bookings.room_type 
        GROUP BY room_type";
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <title>Бөлмелер мен брондау</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('https://phgcdn.com/images/uploads/SDFSB/masthead/SDFSB-masthead-theseelbachhiltonlouisville2.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #333;
        }
        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .room {
            margin-bottom: 40px;
        }
        .slider {
            position: relative;
            margin-bottom: 20px;
        }
        .slider img {
            width: 100%;
            height: auto;
            display: none;
            border-radius: 10px;
        }
        .slider img:first-child {
            display: block;
        }
        .prev, .next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            font-size: 18px;
            padding: 10px;
            cursor: pointer;
            border-radius: 50%;
        }
        .prev {
            left: 10px;
        }
        .next {
            right: 10px;
        }
        .prev:hover, .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }
        .book-now {
            display: inline-block;
            padding: 10px 20px;
            background-color: #d8c3a5;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .book-now:hover {
            background-color: #c3ac8f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Бөлмелер мен брондау</h1>
        
        <!-- Luxury бөлмесі -->
        <div class="room">
            <h2>Luxury бөлмесі</h2>
            <div class="slider" id="luxury-slider">
                <button class="prev">&lt;</button>
                <img src="https://cache.marriott.com/is/image/marriotts7prod/rz-alarz-grand-suite-14672:Wide-Hor?wid=750&fit=constrain=off" alt="Luxury 1">
                <img src="https://cache.marriott.com/is/image/marriotts7prod/rz-alarz-pres-bedroom-13927-17649:Wide-Hor?wid=375&fit=constrain=off" alt="Luxury 2">
                <img src="https://cache.marriott.com/is/image/marriotts7prod/rz-alarz-grand-suite-bathroom19941-67545:Wide-Hor?wid=375&fit=constrain=off" alt="Luxury 3">
                <button class="next">&gt;</button>
            </div>
            <p><strong>Бағасы:</strong> <?= $rooms['luxury']['room_price'] ?? '20 000' ?> ₸/түн</p>
            <h3>Мүмкіндіктер:</h3>
    <ul>
        <li>Тауға қараған көрініс</li>
        <li>Шипажайда толық қызмет көрсету</li>
        <li>VIP қабылдау</li>
        <li>Мини-бар</li>
        <li>Жеке ванна бөлмесі</li>
            <a href="payment.php?room=luxury" class="book-now">Брон жасау</a>
        </div>

        <!-- Standard бөлмесі -->
        <div class="room">
            <h2>Standard бөлмесі</h2>
            <div class="slider" id="standard-slider">
                <button class="prev">&lt;</button>
                <img src="https://cache.marriott.com/is/image/marriotts7prod/rz-alarz-deluxe-room-28812:Wide-Hor?wid=375&fit=constrain=off" alt="Standard 1">
                <img src="https://cache.marriott.com/is/image/marriotts7prod/rz-alarz-deluxe-bathroom-17056:Wide-Hor?wid=375&fit=constrain=off" alt="Standard 2">
                <img src="https://cache.marriott.com/is/image/marriotts7prod/rz-alarz-grand-deluxe-room-41950-17394:Wide-Hor?wid=375&fit=constrain=off" alt="Standard 3">
                <button class="next">&gt;</button>
            </div>
            <p><strong>Бағасы:</strong> <?= $rooms['standard']['room_price'] ?? '15 000' ?> ₸/түн</p>
            <div class="room-features">
    <h3>Мүмкіндіктер:</h3>
    <ul>
    <li>Әдемі интерьер</li>
        <li>Тоңазытқыш</li>
        <li>VIP қабылдау</li>
        <li>Тегін Wi-Fi</li>
        <li>Мини-бар</li>
        <li>Жеке ванна бөлмесі</li>
    </ul>
</div>
            <a href="payment.php?room=standard" class="book-now">Брон жасау</a>
        </div>

        <!-- VIP бөлмесі -->
        <div class="room">
            <h2>VIP бөлмесі</h2>
            <div class="slider" id="vip-slider">
                <button class="prev">&lt;</button>
                <img src="https://cache.marriott.com/is/image/marriotts7prod/rz-alarz-the-ritz-carlton-sui10516-23012:Wide-Hor?wid=375&fit=constrain=off" alt="VIP 1">
                <img src="https://cache.marriott.com/is/image/marriotts7prod/rz-alarz-coffee-maker-25795:Wide-Hor?wid=375&fit=constrain=off" alt="VIP 2">
                <img src="https://cache.marriott.com/is/image/marriotts7prod/rz-alarz-bathroom-amenities-36708:Wide-Hor?wid=375&fit=constrain=off" alt="VIP 3">
                <button class="next">&gt;</button>
            </div>
            <p><strong>Бағасы:</strong> <?= $rooms['vip']['room_price'] ?? '30 000' ?> ₸/түн</p>
            <h3>Мүмкіндіктер:</h3>
            <li>Әдемі интерьер</li>
        <li>Тоңазытқыш</li>
        <li>Жеке бассейн</li>
        <li>VIP қабылдау</li>
        <li>Жоғары жылдамдықты интернет</li>
        <li>Мини-бар мен сусындар</li>
        <li>Жеке ванна бөлмесі</li>
            <a href="payment.php?room=vip" class="book-now">Брон жасау</a>
        </div>
    </div>

    <script>
        document.querySelectorAll('.slider').forEach(slider => {
            const images = slider.querySelectorAll('img');
            const prevBtn = slider.querySelector('.prev');
            const nextBtn = slider.querySelector('.next');
            let currentIndex = 0;

            function showImage(index) {
                images.forEach((img, i) => {
                    img.style.display = i === index ? 'block' : 'none';
                });
            }

            prevBtn.addEventListener('click', () => {
                currentIndex = (currentIndex === 0) ? images.length - 1 : currentIndex - 1;
                showImage(currentIndex);
            });

            nextBtn.addEventListener('click', () => {
                currentIndex = (currentIndex === images.length - 1) ? 0 : currentIndex + 1;
                showImage(currentIndex);
            });

            showImage(currentIndex);
        });
    </script>
</body>
</html>
