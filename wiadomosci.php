<?php
    session_start();

    require_once 'db/connect.php';
    $conn = new mysqli($host, $user, $pass, $db);

    $logged = false;
    if(isset($_SESSION['parent'])) $logged = true;
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/messages.css">
    <!-- <link rel="stylesheet" href="css/admin.css"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        main table{
            font-family: 'Arial', sans-serif;
            margin: 20px auto;
            width: 90%;
            border-collapse: collapse;
        }

        main table, main tr, main td, main th{
            border: 1px solid #ddd;
        }

        main th{
            background-color: var(--bg-primary);
            color: #fff;
            padding: 15px;
            font-weight: bold;
            text-align: left;
            font-size: 16px;
        }

        main td{
            padding: 12px 15px;
            font-size: 15px;
        }

        main .date{
            white-space: nowrap;
        }

        main tr:nth-child(even){
            background-color: var(--bg-tertiary);
        }

        main tr:hover{
            background-color: var(--bg-secondary);
        }

        .messages_table td:nth-child(1), .messages_table th:nth-child(1){
            width: 20%;
        }
        .messages_table td:nth-child(2), .messages_table th:nth-child(2){
            width: 20%;
        }
        .messages_table td:nth-child(3), .messages_table th:nth-child(3){
            width: 60%;
}

    </style>

    <title>Panel rodzica- Niepubliczne Przedszkole "Małe Skrzaty" w Łodzi</title>
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
                <div class="aside__link"><a href="dziecko.php">Informacje o dziecku</a></div>
                <div class="aside__link current"><a href="wiadomosci.php">Wiadomości</a></div>
                <div class="aside__link"><a href="zmien-haslo.php">Zmień hasło</a></div>
                <div class="aside__link logout"><a href="rodzic-logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Wyloguj się</a></div>
                <?php } ?>
            </aside>
            <article>
                <h2>Wiadomości</h2>
                <nav>
                    <div class="nav__links">
                        <div class="nav__link <?php if(!isset($_GET['wyslane'])) echo 'current'; ?>"><a href="wiadomosci.php?"> Skrzynka odbiorcza</a></div>
                        <div class="nav__link <?php if(isset($_GET['wyslane'])) echo 'current'; ?>"><a href="wiadomosci.php?wyslane"> Wysłane</a></div>
                        <div class="nav__link"><a href="napisz-wiadomosc.php">Napisz wiadomość</a></div>
                    </div>
                </nav>
                <?php
                // print_r($_SESSION['parent']);
                $query = '';
                if(isset($_GET['wyslane'])){
                    $query = "SELECT * FROM wiadomosci WHERE nadawca='" . sprintf("p%03d", $_SESSION['parent']['preschooler_id']) ."' OR nadawca='". sprintf("g%03d", $_SESSION['parent']['group']) ."' ORDER BY data_wyslania DESC";
                    // echo $query;
                    $temp = 'odbiorca';
                }else{
                    $query = "SELECT * FROM wiadomosci WHERE odbiorca='" . sprintf("p%03d", $_SESSION['parent']['preschooler_id']) ."' OR odbiorca='". sprintf("g%03d", $_SESSION['parent']['group']) ."' ORDER BY data_wyslania DESC";
                    $temp = 'nadawca';
                }
                $result = $conn->query($query);

                echo '<table class="messages_table">';
                echo '<tr>';
                echo '<th>Data wysłania</th>';
                echo '<th>'.ucfirst($temp).'</th>';
                echo '<th>Tytuł</th>';
                echo '</tr>';

                while ($row = $result->fetch_assoc()) {
                    $temp_temp = $row[$temp];

                    if(substr($temp_temp, 0, 1) == 'n'){
                        $temp_temp = substr($temp_temp, 1);
                        $id = intval(substr($temp_temp, 1));
                        $query2 = 'SELECT CONCAT(imie," ",nazwisko) AS temp_name FROM nauczyciele WHERE id_nauczyciela='.$id;
                    }elseif (substr($temp_temp, 0, 1) == 'p') {
                        $temp_temp = substr($temp_temp, 1);
                        $id = intval(substr($temp_temp, 1));
                        $query2 = 'SELECT CONCAT(imie," ",nazwisko) AS temp_name FROM przedszkolaki WHERE id_przedszkolaka='.$id;
                    }elseif (substr($temp_temp, 0, 1) == 'g') {
                        $temp_temp = substr($temp_temp, 1);
                        $id = intval(substr($temp_temp, 1));
                        $query2 = 'SELECT nazwa_grupy AS temp_name FROM grupy WHERE id_grupy='.$id;
                    }

                    $result2 = $conn->query($query2);
                    $row2 = $result2->fetch_assoc();
                    $temp_name = $row2['temp_name'];
                    $result2->free_result();

                    echo '<tr>';
                    echo '<td>'.$row['data_wyslania'].'</td>';
                    echo '<td>'.$temp_name.'</td>';
                    echo '<td class="message_link"><a href="wiadomosc.php?id='.$row['id_wiadomosci'].'">'.$row['temat'].'</a></td>';
                    echo '</tr>';
                }

                echo '</table>';
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