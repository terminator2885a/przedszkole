<?php
    require_once 'admin/functions.php';
    require_once 'db/connect.php';

    $conn = new mysqli($host, $user, $pass, $db);
    mysqli_set_charset($conn, 'utf8mb4');
    
    $query1 = "SELECT id_nauczyciela, CONCAT(imie, ' ', nazwisko) AS imie_i_nazwisko, ranga FROM nauczyciele ORDER BY ranga, id_nauczyciela";

    // $query2 = "SELECT nazwa_grupy FROM grupy WHERE wychowawca1=". $_SESSION['user']['id'] . " OR wychowawca2=" . $_SESSION['user']['id'];

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
    <title>Nasze nauczycielki - Niepubliczne Przedszkole "Małe Skrzaty" w Łodzi</title>
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
                <div class="nav__link current"><a href="index.html">O nas</a></div>
                <div class="nav__link"><a href="grupy.php">Grupy</a></div>
                <div class="nav__link"><a href="wydarzenia.php">Wydarzenia</a></div>
                <div class="nav__link"><a href="kalendarium.html">Kalendarium</a></div>
                <div class="nav__link"><a href="rodzic.php">Kącik rodzica</a></div>
                <div class="nav__link"><a href="admin/index.php">Panel nauczyciela</a></div>
            </div>
        </nav>
    
        <main>
            <aside>
                <div class="aside__link current"><a href="nauczyciele.php">Nasze nauczycielki</a></div>
                <div class="aside__link"><a href="plan_dnia.html">Rozkład dnia</a></div>
                <div class="aside__link"><a href="rekrutacja.html">Rekrutacja</a></div>
                <div class="aside__link"><a href="rodo.html">Ochrona danych osobowych</a></div>
                <div class="aside__link"><a href="maloletni.html">Standardy ochrony małoletnich</a></div>
                <div class="aside__link"><a href="https://bip.gov.pl">Biuletyn informacji publicznej</a></div>
            </aside>
            <article>
                <h2>Nasze nauczycielki</h2>
                <?php
                    $result1 = $conn->query($query1);
                    $prev = 0;
                    while($row = $result1->fetch_assoc()){
                        if($row['ranga'] == 1){
                            echo '<div class="teacher-banner">';
                            echo '<div class="img teacher-banner__img">';
                            echo '<img src="img/teachers/' . removePolishCharacters(strtolower(str_replace(' ', '_', $row['imie_i_nazwisko']) . '.jpg">'));
                            echo '</div>';
                            echo '<h4>' . $row['imie_i_nazwisko'] . '</h4>';
                            echo '<h4>Dyrektor przedszkola</h4>';
                            echo '</div>';
                            $prev = 1;
                        }else if($row['ranga']==2){
                            if($prev == 1){
                                $prev = 2;
                                echo '<ul>';
                            }
                            $query2 = "SELECT nazwa_grupy FROM grupy WHERE wychowawca1=". $row['id_nauczyciela'] . " OR wychowawca2=" . $row['id_nauczyciela'];
                            $result2 = $conn->query($query2);
                            $group_name = $result2->fetch_assoc()['nazwa_grupy'];
                            echo '<li><span class="teacher__name">' . $row['imie_i_nazwisko'] . '</span> - wychowawca grupy ' . $group_name . '</li>';
                        }else{
                            if($prev == 2){
                                $prev = 3;
                            }
                            $query3 = "SELECT nazwa_rangi FROM rangi WHERE id_rangi=". $row['ranga'];
                            $result3 = $conn->query($query3);
                            $rank_name = $result3->fetch_assoc()['nazwa_rangi'];
                            echo '<li><span class="teacher__name">' . $row['imie_i_nazwisko'] . '</span> - '. $rank_name . '</li>';
                        }
                    }

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
