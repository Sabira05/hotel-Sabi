<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <title>Golden Star Қонақ Үйі</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('https://m.ahstatic.com/is/image/accorhotels/aja_p_5553-45?qlt=82&wid=1920&ts=1729248820030&dpr=off'); /* Артқы фон суреті */
            background-size: cover;
            background-position: center;
            background-attachment: fixed; /* Сурет парақпен бірге қозғалмайды */
            color: #333;
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.5); /* Жартылай мөлдір қара қабат */
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 180%;
            z-index: -1; /* Контенттің астында болады */
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9); /* Ақшыл мөлдір фон */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1;
            position: relative;
        }

        .container img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .container h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: #444;
        }

        .container h2 {
            font-size: 1.8rem;
            margin-bottom: 15px;
            color: #666;
        }

        .container p {
            font-size: 1rem;
            line-height: 1.8;
            margin-bottom: 15px;
        }

        .services ul {
            margin-left: 20px;
            list-style-type: disc;
        }

        .services ul li {
            margin-bottom: 10px;
        }
        
        .slider {
            position: relative;display
            max-width: 100%;
            margin: 20px 0;

        }
        .slider img {
            width: auto; /* Ені автоматты түрде анықталады */
            max-width: 100%; /* Блоктың шекарасынан шықпайды */
            max-height: 300px; /* Биіктігін шектейміз */
            object-fit: cover; /* Пропорцияны сақтай отырып, суретті қиып көрсету */
            border-radius: 10px; /* Жиектерін жұмсартады */
            margin: 0 auto; /* Ортасына туралау */
            display: block; /* Суреттердің блоктық орналасуы */
        }

        .prev, .next {
            position: absolute;
            top: 50%;
            transform:translateY(-50%);
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


        .contact-info {
            mfont-family: Arial, sans-serif;
            color: #333;
        }

        .contact-info h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .contact-info p {
            font-size: 1rem;
            margin-bottom: 8px;
        }
        .contact-info .social-links a {
            margin-right: 10px;
        }

        .contact-info .social-links .icon {
            width: 30px;
            height: 30px;
            object-fit: contain;
        }

        .contact-info .social-links a:hover .icon {
            opacity: 0.7;
        }
        .contact-info a {
            color: #007BFF;
            text-decoration: none;
        }

        .contact-info a:hover {
            color: #0056b3;
        }

        .social-links a {
            display: inline-block;
            margin-right: 10px;
            color: #fff;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 0.9rem;
        }

        .social-links a.instagram {
            background-color: #E4405F;
        }

        .social-links a.whatsapp {
            background-color: #25D366;
        }
        .back-to-home {
            margin-top: 20px;
            display:inline-block;
            padding: 5px 10px;
            background-color: #d8c3a5;
            color: white;
            text-decoration: none;
            border-radius: 1px;
            font-size: 0.9rem;
            width: auto; /* Автоматты түрде енін қысқартады */
            white-space: nowrap;
        }
        .back-to-home:hover {
            background-color: #c3ac8f;
        }
    </style>
</head>
<body>

<div class="overlay"></div>

<div class="container">
    <h1>Алматыдағы "Golden Star" Қонақ Үйі</h1>
    <h2>"Тау бөктеріндегі сән-салтанат мекені"</h2>
    <div class="slider">
            <button class="prev">&lt;</button>
            <img src="https://s.hdnux.com/photos/01/05/45/43/18241744/4/1920x0.jpg" alt="Hotel 1">
            <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjN7tQ8fIdE7LqvXiLzCmmlK5MErUglRyZobDZbH5gLf650XmpaP6nHFx0uBKNY8Po8_zKl-efZe5xub8zndTjf2PG72vxW3gnbnz0gpxRGoK0UV-e2LR9Cs3K8aqPxPd-aSPvwbi62l14/s1863/raffles+singapore+grand+lobby.jpg" alt="Hotel 2" style="display: none;">
            <img src="https://m.ahstatic.com/is/image/accorhotels/aja_p_5629-59?qlt=82&wid=1920&ts=1710858232816&dpr=off" alt="Hotel 3" style="display: none;">
            <img src="https://m.ahstatic.com/is/image/accorhotels/aja_p_5195-48?qlt=82&wid=1920&ts=1693942021648&dpr=off" alt="Hotel 4" style="display: none;">
            <img src="https://m.ahstatic.com/is/image/accorhotels/aja_p_5629-25?qlt=82&wid=1920&ts=1710944159228&dpr=off" alt="Hotel 5" style="display: none;">
            <img src="https://m.ahstatic.com/is/image/accorhotels/aja_p_5629-41?qlt=82&wid=1920&ts=1693943551070&dpr=off" alt="Hotel 6" style="display: none;">
            <button class="next">&gt;</button>
        </div>
    <p>
        Алматы қаласының көркем тауларының етегінде орналасқан <strong>"Golden Star"</strong> қонақ үйі 1995 жылы ашылды және сол уақыттан бері қаладағы сән-салтанат пен ерекше қонақжайлылықтың символына айналды. Бұл қонақ үй керемет табиғат көріністері мен заманауи жайлылықты үйлестіре отырып, әрбір қонақтың жүрегіне жол табады.
    </p>
    <p>
        "Golden Star" атауы өзінің жарқыраған жұлдыздай қызмет көрсетуімен белгілі. Қонақ үй алғаш рет есігін ашқаннан бері мәдениет өкілдері, саяси қайраткерлер мен әлемнің түкпір-түкпірінен келген саяхатшылар үшін сүйікті орынға айналды. Әрбір бөлмесі заманауи интерьер мен қазақ халқының ұлттық нақышындағы элементтермен безендірілген.
    </p>

    <div class="services">
        <h2>Қызметтер:</h2>
        <ul>
            <li><strong>Сәнді бөлмелер мен люкстер:</strong> Жайлылықтың жоғарғы деңгейі мен таңғажайып тау көрінісі.</li>
            <li><strong>Мейрамханалар мен лаунж аймақтары:</strong> Қазақ және әлемдік асхананың үздік тағамдары ұсынылады.</li>
            <li><strong>Конференц-залдар:</strong> Іскерлік кездесулер мен іс-шараларға арналған заманауи жабдықталған кеңістіктер.</li>
            <li><strong>SPA және фитнес-орталық:</strong> Қонақтардың толық демалып, сергіп қайтуына арналған.</li>
        </ul>
    </div>

    <div class="contact-info">
    <h3>Байланыс ақпараттары</h3>
    <p><strong>Телефон:</strong> +7 (727) 123-45-67</p>
    <p><strong>Мекенжай:</strong> Алматы қ., Достық даңғылы, 123</p>
    <p><strong>Email:</strong> <a href="mailto:info@goldenstar.kz">info@goldenstar.kz</a></p>
    <div class="social-links">
        <a class="instagram" href="https://www.instagram.com/goldenstar" target="_blank">
            <img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" alt="Instagram" class="icon">
        </a>
        <a class="whatsapp" href="https://wa.me/77012345678" target="_blank">
            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" class="icon">
        </a>
    </div>
</div>
    <a href="index.php" class="back-to-home">Басты бетке оралу</a>
</div>
<script>
        const images = document.querySelectorAll('.slider img');
        const prevBtn = document.querySelector('.prev');
        const nextBtn = document.querySelector('.next');
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
    </script>

</body>
</html>
