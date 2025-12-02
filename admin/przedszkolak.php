<?php
    session_start();
    if(!isset($_SESSION['user'])) {header('Location: login-page.php'); exit();}
    if($_SESSION['user']['rank'] != 1 && $_SESSION['user']['rank'] != 2) {echo '<script>alert("Nie masz uprawnień");</script>'; header('Location: index.php'); exit();}

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

    if(isset($_GET['id'])){
        $preschooler_id = $_GET['id'];
        $query = sprintf("SELECT * FROM przedszkolaki WHERE id_przedszkolaka=%d", $preschooler_id);
        $result = $conn->query($query);
        $preschooler = $result->fetch_assoc();
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

    <title>Panel nauczyciela - Niepubliczne Przedszkole "Małe Skrzaty" w Łodzi</title>
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
                <div class="nav__link"><a href="index.php">Grupy</a></div>
                <div class="nav__link dropdown current">
                    Przedszkolaki
                    <ul>
                        <li class="current"><a href="przedszkolaki.php">Przegląd</a></li>
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
                <div class="nav__link"><a href="wiadomosci.php">Wiadomości</a></div>
                <div class="nav__link"><a href="zmien-haslo.php">Zmień hasło</a></div>
                <div class="nav__link logout"><a href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Wyloguj się</a></div>
            </div>

             <?php
            } else if($_SESSION['user']['rank'] == 2){ 
            ?>
            <h3>Panel wychowawcy</h3>
            <div class="nav__links">
                <div class="nav__link current"><a href="index.php">Moja grupa</a></div>
                <div class="nav__link"><a href="przedszkolaki.php">Moje przedszkolaki</a></div>
                <div class="nav__link"><a href="artykul.php">Dodaj artykuł</a></div>
                <div class="nav__link"><a href="wiadomosci.php">Wiadomości</a></div>
                <div class="nav__link"><a href="zmien-haslo.php">Zmień hasło</a></div>
                <div class="nav__link logout"><a href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Wyloguj się</a></div>
            </div>
            <?php } ?>
        </nav>

        <main>
            <h2>Przegląd przedszkolaka</h2>
            <?php
                    require_once 'functions.php';
                    echo '<div class="preschooler-banner">';
                    echo '<div class="img preschooler-banner__img">';
                    $src = getGender($preschooler['pesel']) == 'M' ? 'boy.jpg' : 'girl.jpg';
                    echo '<img src="../img/preschoolers/'. $src . '" alt="przedszkolak">';
                    echo '</div>';
                    echo '<h3>' . $preschooler['imie'] .' '. $preschooler['nazwisko'] .'</h3>';
                    if (getGender($preschooler['pesel']) === 'M') {
                        echo '<h4>Chłopiec</h4>';
                    } else {
                        echo '<h4>Dziewczynka</h4>';
                    }

                    $group_name = $conn->query("SELECT nazwa_grupy FROM grupy WHERE id_grupy=". $preschooler['grupa'])->fetch_assoc()['nazwa_grupy'];
                    echo '<h4>Grupa: ' . $group_name .'</h4>';
                    echo '<h4>Data urodzenia: ' . date_format(date_create(birthDate($preschooler['pesel'])), 'j.m.Y') .'r.</h4>';
                    if($preschooler['alergeny'] == '') echo '<h4>Brak zgłoszonych alergenów</h4>';
                    else echo '<h4>Zgłoszone alergeny: ' . $preschooler['alergeny'] .'</h4>';
                    if($_SESSION['user']['rank']==1) echo '<a class="form-cancel" href="edytuj-przedszkolaka.php?preschooler_id=' . $preschooler['id_przedszkolaka'] .'">Edytuj</a>';
                    echo '</div>';
            ?>
        </main>
    </div>
</body>
</html>

<?php
    $conn->close();
?>