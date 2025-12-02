<?php
    session_start();
    require_once 'db/connect.php';
    $conn = new mysqli($host, $user, $pass, $db);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <!-- <link rel="stylesheet" href="css/plan_dnia.css"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>

        .menu-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            font-size: 16px;
        }
        
        .menu-table thead {
            background-color: var(--bg-primary);
            color: #fff;
        }
        
        .menu-table th, .menu-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .menu-table th {
            font-weight: bold;
            text-shadow: 1px 1px 0 #000;
        }
        
        .menu-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .menu-table tbody tr:hover {
            background-color: var(--bg-tertiary);
        }
        
        .meal-time {
            font-weight: bold;
            color: var(--text);
        }
        
        .meal-item {
            color: #333;
        }
    </style>
    <title>Jadłospis - Niepubliczne Przedszkole "Małe Skrzaty" w Łodzi</title>
</head>
<body>
    <div class="page">
        <header>
            <h1>Niepubliczne przedszkole "Małe Skrzaty" w Łodzi</h1>
        </header>
        <div class="banner">
            <img src="img/baner1.png" alt="baner">
        </div>
        <nav>
            <div class="nav__links">
                <div class="nav__link"><a href="index.html">O nas</a></div>
                <div class="nav__link"><a href="grupy.php">Grupy</a></div>
                <div class="nav__link"><a href="wydarzenia.php">Wydarzenia</a></div>
                <div class="nav__link"><a href="kalendarium.html">Kalendarium</a></div>
                <div class="nav__link current"><a href="rodzic.php">Kącik rodzica</a></div>
                <div class="nav__link"><a href="admin/index.php">Panel nauczyciela</a></div>
            </div>
        </nav>
    
        <main>
            <aside>
                <div class="aside__link"><a href="rodzic.php">Komunikaty dyrekcji</a></div>
                <div class="aside__link current"><a href="jadlospis.php">Jadłospis</a></div>
                <?php
                    $logged = isset($_SESSION['parent']) ? true : false;
                    if(!$logged){
                ?>
                <div class="aside__link"><a href="rodzic-login.php">Zaloguj się</a></div>
                <?php } else { ?>
                <div class="aside__link"><a href="dziecko.php">Informacje o dziecku</a></div>
                <div class="aside__link"><a href="wiadomosci.php">Wiadomości</a></div>
                <div class="aside__link logout"><a href="rodzic-logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Wyloguj się</a></div>
                <?php } ?>
            </aside>
            <article>
                <h2>Jadłospis tygodniowy  <i class="fa-solid fa-arrow-right"></i> 1.12-5.12</h2>
                <p>Zapraszamy do zapoznania się z naszym tygodniowym jadłospisem. Wszystkie posiłki przygotowywane są w naszej własnej kuchni z użyciem świeżych, wysokiej jakości składników. Staramy się zapewnić zbilansowaną dietę wspierającą zdrowy rozwój Waszych dzieci.</p>
                
                <table class="menu-table">
                    <thead>
                        <tr>
                            <th>Poniedziałek</th>
                            <th>Wtorek</th>
                            <th>Środa</th>
                            <th>Czwartek</th>
                            <th>Piątek</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="meal-item">Bułka z masłem i serkiem</td>
                            <td class="meal-item">Jajecznica na piekarni</td>
                            <td class="meal-item">Chleb z mielonką</td>
                            <td class="meal-item">Kanapka z serem toponym</td>
                            <td class="meal-item">Naleśniki ze słodkim sosem</td>
                        </tr>
                        <tr>
                            <td class="meal-item">Jabłko, ciastko</td>
                            <td class="meal-item">Banan, batón</td>
                            <td class="meal-item">Pomarańcza, bułka</td>
                            <td class="meal-item">Gruszka, ciastko</td>
                            <td class="meal-item">Truskawki, wafel</td>
                        </tr>
                        <tr>
                            <td class="meal-item"><strong>Rosół z makaronem<br>Klopsiki z ryżem<br>Surówka z kapusty</strong></td>
                            <td class="meal-item"><strong>Żurek ze słonką<br>Chleb żytni<br>Ogórek kiszony</strong></td>
                            <td class="meal-item"><strong>Zupa mleczna<br>Mielone mięso<br>Marchewka, brukselka</strong></td>
                            <td class="meal-item"><strong>Barszcz czerwony<br>Kurczak piecze­ny<br>Ziemniaki, mizeria</strong></td>
                            <td class="meal-item"><strong>Pomidorowa<br>Filet z kurczaka<br>Makaron, sałata</strong></td>
                        </tr>
                        <tr>
                            <td class="meal-item">Sernik ze śliwkami</td>
                            <td class="meal-item">Makowiec</td>
                            <td class="meal-item">Ciasto drożdżowe</td>
                            <td class="meal-item">Pączki</td>
                            <td class="meal-item">Chrust i kompot</td>
                        </tr>
                    </tbody>
                </table>

                <h4 style="margin-top: 30px;">Ważne informacje:</h4>
                <ul>
                    <li>Wszystkie posiłki przygotowywane są w naszej kuchni każdego dnia</li>
                    <li>Używamy wyłącznie świeżych produktów wysokiej jakości</li>
                    <li>Posiłki są zbilansowane pod względem energetycznym i odżywczym</li>
                    <li>Oferujemy opcje bez glutenu dla dzieci z celiakią</li>
                    <li>Możliwe są indywidualne ograniczenia dietetyczne (alergie, uczulenia)</li>
                    <li>W razie pytań lub wątpliwości prosimy o kontakt z kierownictwem przedszkola</li>
                </ul>

                <p style="margin-top: 20px; color: var(--text); font-weight: bold;">
                    W każdy poniedziałek jadłospis może się zmienić. Bieżące zmiany będą publikowane w komunikatach dyrekcji.
                </p>
            </article>
        </main>
        <footer>
            <table>
                <tr><th>Adres</th><th>Kontakt</th><th>Mapa</th></tr>
                <tr>
                    <td>ul. Wesoła 12</td>
                    <td>E-mail: <a href="mailto:kontakt@maleskrzaty.pl">kontakt@maleskrzaty.pl</a></td>
                    <td rowspan="2">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d733.6564960265912!2d19.482710198832795!3d51.79308105045472!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x471bcb1cb30d33df%3A0x3bddd46b3ba43f17!2sPrzedszkole%20nr%209%20Miejskie!5e0!3m2!1spl!2spl!4v1762619710896!5m2!1spl!2spl" width="150" height="112" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </td>
                </tr>
                <tr>
                    <td>93-152 Łódź</td>
                    <td>Tel.: <a href="tel:426784532">42 678 45 32</a></td>
                </tr>
            </table>
        </footer>
    </div>
</body>
</html>

<?php
    $conn->close();
?>
