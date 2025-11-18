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
        $row = $result->fetch_assoc();
        $_SESSION['group_name'] = $row['nazwa_grupy'];

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
    <title>Panel dyrektorski - Niepubliczne Przedszkole "Małe Skrzaty" w Łodzi</title>
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
                        echo '<h4>Wychowawca grupy '. $_SESSION['group_name'] .'</h4>';
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
                <div class="nav__link current"><a href="index.php">Grupy</a></div>
                <div class="nav__link dropdown">
                    Przedszkolaki
                    <ul>
                        <li><a href="przedszkolaki.php">Przegląd</a></li>
                        <li><a href="">Dodaj</a></li>
                    </ul>
                </div>
                <div class="nav__link dropdown">
                    Nauczyciele
                    <ul>
                        <li><a href="nauczyciele.php">Przegląd</a></li>
                        <li><a href="">Dodaj</a></li>
                    </ul>
                </div>
                <div class="nav__link dropdown">
                    Wpisy
                    <ul>
                        <li><a href="">Nowy artykuł</a></li>
                        <li><a href="">Nowy komunikat</a></li>
                    </ul>
                </div>
                <div class="nav__link"><a href="">Wiadomości</a></div>
                <div class="nav__link logout"><a href="logout.php">Wyloguj się</a></div>
            </div>

             <?php
            } else if($_SESSION['user']['rank'] == 2){ 
            ?>
            <h3>Panel wychowawcy</h3>
            <div class="nav__links">
                <div class="nav__link current"><a href="">Moja grupa</a></div>
                <div class="nav__link"><a href="">Moje przedszkolaki</a></div>
                <div class="nav__link"><a href="">Dodaj artykuł</a></div>
                <div class="nav__link"><a href="">Wiadomości</a></div>
                <div class="nav__link logout"><a href="logout.php">Wyloguj się</a></div>
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
                <div class="nav__link"><a href="">Dodaj artykuł</a></div>
                <div class="nav__link"><a href="">Wiadomości</a></div>
                <div class="nav__link logout"><a href="logout.php">Wyloguj się</a></div>
            </div>
            <?php
            }
            ?>
        </nav>
    </div>
</body>
</html>

<?php
    $conn->close();
?>