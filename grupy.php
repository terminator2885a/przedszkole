<?php
    session_start();
    require_once 'db/connect.php';
    $conn = new mysqli($host, $user, $pass, $db);

    $query1 = "SELECT COUNT(id_grupy) AS cnt FROM grupy";
    $result1 = $conn->query($query1);
    $cnt_groups = $result1->fetch_assoc()['cnt'];
    $result1->free_result();

    $query2 = "SELECT id_grupy, nazwa_grupy, opis_grupy, CONCAT(n1.imie, ' ', n1.nazwisko) AS 'wych1', CONCAT(n2.imie, ' ', n2.nazwisko) AS 'wych2' FROM grupy LEFT JOIN nauczyciele n1 ON grupy.wychowawca1 = n1.id_nauczyciela LEFT JOIN nauczyciele n2 ON grupy.wychowawca2=n2.id_nauczyciela";
    $result2 = $conn->query($query2);
    $_SESSION['records'] = array();
    while($row = $result2->fetch_assoc()){
        $_SESSION['records'][]= $row;
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
    <title>Grupy - Niepubliczne Przedszkole "Małe Skrzaty" w Łodzi</title>
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
                <div class="nav__link current"><a href="grupy.php">Grupy</a></div>
                <div class="nav__link"><a href="wydarzenia.php">Wydarzenia</a></div>
                <div class="nav__link"><a href="kalendarium.html">Kalendarium</a></div>
                <div class="nav__link"><a href="rodzic.php">Kącik rodzica</a></div>
                <div class="nav__link"><a href="admin/index.php">Panel nauczyciela</a></div>
            </div>
        </nav>
    
        <main>
            <aside>
                <!-- Aside generowany przez php -->
                 <div class="aside__link current"><a href="grupy.php">Grupy</a></div>
                 <?php
                    for($i=0; $i<count($_SESSION['records']); $i++){
                        echo '<div class="aside__link"><a href="grupa.php?grupa=' . $_SESSION['records'][$i]['id_grupy'] . '">' . $_SESSION['records'][$i]['nazwa_grupy'] . '</a></div>';
                    }
                 ?>
            </aside>
            <article>
                <h2>Grupy</h2>
                <p>W naszym przedszkolu funkcjonują <?php echo $cnt_groups; ?> grupy, które są zróżnicowane pod względem wiekowym, co pozwala dostosować program i aktywności do potrzeb dzieci na różnych etapach rozwoju. Dzięki temu każda grupa ma swoje indywidualne zajęcia, sprzyjające harmonijnemu rozwojowi i integracji.</p>
                <h4>Nasze grupy:</h3>
                <ol>
                    <?php
                        for($i=0; $i<count($_SESSION['records']); $i++){
                            echo '<li>' . $_SESSION['records'][$i]['nazwa_grupy'] . '</li>';
                        }
                    ?>
                </ol>
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