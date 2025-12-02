<?php
    session_start();

    require_once 'db/connect.php';
    $conn = new mysqli($host, $user, $pass, $db);

    $logged = false;
    if(isset($_SESSION['parent'])) $logged = true;
    else{
        header('Location: rodzic.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Moje dziecko - Niepubliczne Przedszkole "Małe Skrzaty" w Łodzi</title>
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
                <div class="aside__link"><a href="jadlospis.php">Jadłospis</a></div>
                <?php
                if(!$logged){
                ?>
                <div class="aside__link"><a href="rodzic-login.php">Zaloguj się</a></div>
                <?php } else { ?>
                <div class="aside__link current"><a href="dziecko.php">Informacje o dziecku</a></div>
                <div class="aside__link"><a href="wiadomosci.php">Wiadomości</a></div>
                <div class="aside__link"><a href="zmien-haslo.php">Zmień hasło</a></div>
                <div class="aside__link logout"><a href="rodzic-logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Wyloguj się</a></div>
                <?php } ?>
            </aside>
            <article>
                <h2>Moje dziecko</h2>
                
                <?php
                    require_once 'admin/functions.php';
                    echo '<div class="preschooler-banner">';
                    echo '<div class="img preschooler-banner__img">';
                    $src = getGender($_SESSION['parent']['pesel']) == 'M' ? 'boy.jpg' : 'girl.jpg';
                    echo '<img src="img/preschoolers/'. $src . '" alt="przedszkolak">';
                    echo '</div>';
                    echo '<h3>' . $_SESSION['parent']['f_name'] .' '. $_SESSION['parent']['l_name'] .'</h3>';
                    if (getGender($_SESSION['parent']['pesel']) === 'M') {
                        echo '<h4>Chłopiec</h4>';
                    } else {
                        echo '<h4>Dziewczynka</h4>';
                    }

                    $group_name = $conn->query("SELECT nazwa_grupy FROM grupy WHERE id_grupy=". $_SESSION['parent']['group'])->fetch_assoc()['nazwa_grupy'];
                    echo '<h4>Grupa: ' . $group_name .'</h4>';
                    echo '<h4>Data urodzenia: ' . date_format(date_create(birthDate($_SESSION['parent']['pesel'])), 'j.m.Y') .'r.</h4>';
                    if($_SESSION['parent']['allergens'] == '') echo '<h4>Brak zgłoszonych alergenów</h4>';
                    else echo '<h4>Zgłoszone alergeny: ' . $_SESSION['parent']['allergens'] .'</h4>';
                    echo '</div>';
                ?>
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