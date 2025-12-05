<?php
    session_start();
    if(!isset($_SESSION['user'])) {header('Location: login-page.php'); exit();}


    // print_r($_SESSION['user']);
    // Nazwa roli
    require_once '../db/connect.php';
    $conn = new mysqli($host, $user, $pass, $db);
    mysqli_set_charset($conn, 'utf8mb4');

    $result = $conn->query('SELECT nazwa_rangi FROM rangi WHERE id_rangi='. $_SESSION['user']['rank']);
    $row = $result->fetch_assoc();
    $_SESSION['user']['rank_name'] = $row['nazwa_rangi'];
    $result->free_result();

    if($_SESSION['user']['rank'] == 2){
        $query = //sprintf("SELECT nazwa_grupy FROM grupy WHERE wychowawca1='%s' OR wychowawca2='%s'", $_SESSION['user']['id'], $_SESSION['user']['id']);
        "SELECT nazwa_grupy FROM grupy WHERE wychowawca1=". $_SESSION['user']['id'] . " OR wychowawca2=" . $_SESSION['user']['id'];

        $result = $conn->query($query);
        if($result->num_rows != 0){
            $row = $result->fetch_assoc();
            $_SESSION['group_name'] = $row['nazwa_grupy'];
        }else{
            $_SESSION['group_name'] = null;
        }
        
        $result->free_result();

    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Wiadomości - Niepubliczne Przedszkole "Małe Skrzaty" w Łodzi</title>
</head>
<body>
    <div class="page">
        <header>
            <h1>Niepubliczne przedszkole "Małe Skrzaty" w Łodzi</h1>
        </header>
    
        <div class="teacher-banner">
            <!-- <div class="img teacher-banner__img">
                <img src="../img/teacher.jpg" alt="">
            </div>
    
            <h3>Joanna Zawadzka</h3>
            <h4>Dyrektor przedszkola</h4> -->

            <?php
                require_once 'functions.php';
                echo '<div class="img teacher-banner__img">';
                echo '<img src="../img/teachers/' . removePolishCharacters(strtolower($_SESSION['user']['f_name'] . '_' . $_SESSION['user']['l_name'] . '.jpg">'));
                echo '</div>';

                echo '<h3>' . $_SESSION['user']['f_name'] . ' ' . $_SESSION['user']['l_name'] . '</h3>';
                switch($_SESSION['user']['rank']){
                    case 1:
                        echo '<h4>Dyrektor przedszkola</h4>';
                        break;
                    case 2:
                        if(!is_null($_SESSION['group_name'])) {
                            echo '<h4>Wychowawca grupy '. $_SESSION['group_name'] .'</h4>';
                        }else{
                            echo '<h4>Masz uprawnienia wychowawcy, z których nie możesz skorzystać, ponieważ nie jesteś wychowawcą żadnej grupy.</h4>';
                        }
                        break;
                    default:
                        echo '<h4>' . ucfirst($_SESSION['user']['rank_name']) . '</h4>';
                        break;
                }
            ?>
            <!-- <p><b style="color: red;">Ważne:</b> Strona przedszkola nie jest od zarządzania sprawami kadrowymi. Przedszkolny system oferuje zarządzanie grupami oraz przedszkolakami. Do spraw takich jak urlopy, zwolnienia, płace, należy skorzystać z innych narzędzi.</p> -->
        </div>

        <nav>
            <?php if($_SESSION['user']['rank'] == 1){ ?>
            <h3>Panel dyrektorski</h3>
            <div class="nav__links">
                <div class="nav__link"><a href="index.php">Grupy</a></div>
                <div class="nav__link dropdown">
                    Przedszkolaki
                    <ul>
                        <li><a href="przedszkolaki.php">Przegląd</a></li>
                        <li><a href="edytuj-przedszkolaka.php">Dodaj</a></li>
                    </ul>
                </div>
                <div class="nav__link dropdown">
                    Nauczyciele
                    <ul>
                        <li><a href="nauczyciele.php">Przegląd</a></li>
                        <li><a href="edytuj-nauczyciela.php">Dodaj</a></li>
                    </ul>
                </div>
                <div class="nav__link dropdown">
                    Wpisy
                    <ul>
                        <li><a href="artykul.php">Artykuły</a></li>
                        <li><a href="komunikat.php">Komunikaty</a></li>
                    </ul>
                </div>
                <div class="nav__link current"><a href="wiadomosci.php">Wiadomości</a></div>
                <div class="nav__link"><a href="zmien-haslo.php">Zmień hasło</a></div>
                <div class="nav__link logout"><a href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Wyloguj się</a></div>
            </div>

             <?php
            } else if($_SESSION['user']['rank'] == 2){ 
            ?>
            <h3>Panel wychowawcy</h3>
            <div class="nav__links">
                <?php if(!is_null($_SESSION['group_name'])) { ?>
                <div class="nav__link"><a href="index.php">Moja grupa</a></div>
                <div class="nav__link"><a href="przedszkolaki.php">Moje przedszkolaki</a></div>
                <?php } ?>
                <div class="nav__link"><a href="artykul.php">Dodaj artykuł</a></div>
                <div class="nav__link current"><a href="wiadomosci.php">Wiadomości</a></div>
                <div class="nav__link"><a href="zmien-haslo.php">Zmień hasło</a></div>
                <div class="nav__link logout"><a href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Wyloguj się</a></div>
            </div>
            <?php
            }else{
            ?>
            <h3>
                <?php
                    switch ($_SESSION['user']['rank']){
                        case 3:
                            echo 'Panel nauczyciela języka angielskiego';
                            break;
                        case 4:
                            echo 'Panel nauczyciela religii';
                            break;
                        case 5:
                            echo 'Panel nauczyciela muzyki i rytmiki';
                            break;
                        case 6:
                            echo 'Panel pomocy nauczycielskiej';
                            break;
                    }
                    ?>
            </h3>

            <div class="nav__links">
                <div class="nav__link"><a href="artykul.php">Dodaj artykuł</a></div>
                <div class="nav__link current"><a href="wiadomosci.php">Wiadomości</a></div>
                <div class="nav__link"><a href="zmien-haslo.php">Zmień hasło</a></div>
                <div class="nav__link logout"><a href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Wyloguj się</a></div>
            </div>
            <?php
            }
            ?>
        </nav>

        <main>
            <aside>
                <div class="aside__link <?php if(!isset($_GET['wyslane'])) echo 'current'; ?>"><a href="?">Skrzynka odbiorcza</a></div>
                <div class="aside__link <?php if(isset($_GET['wyslane'])) echo 'current'; ?>"><a href="?wyslane">Wysłane</a></div>
                <div class="aside__link"><a href="napisz-wiadomosc.php">Napisz wiadomość</a></div>
            </aside>

            <section>
            <?php
                $query = '';
                if(isset($_GET['wyslane'])){
                    $query = "SELECT * FROM wiadomosci WHERE nadawca='" . sprintf("n%03d", $_SESSION['user']['id']) ."' ORDER BY data_wyslania DESC";
                    $temp = 'odbiorca';
                }else{
                    $query = "SELECT * FROM wiadomosci WHERE odbiorca='" . sprintf("n%03d", $_SESSION['user']['id']) ."' ORDER BY data_wyslania DESC";
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
            </section>
        </main>
    </div>
</body>
</html>

<?php
    $conn->close();
?>