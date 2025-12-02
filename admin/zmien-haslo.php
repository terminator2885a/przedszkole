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


    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $row = $conn->query("SELECT * FROM nauczyciele WHERE id_nauczyciela=". $_SESSION['user']['id'])->fetch_assoc();

        if(password_verify($_POST['old_password'], $row['password'])){
            if($_POST['new_password1'] == $_POST['new_password2']){
                $hashedPassword = password_hash($_POST['new_password1'], PASSWORD_DEFAULT);
                $conn->query("UPDATE nauczyciele SET password='$hashedPassword' WHERE id_nauczyciela=".$_SESSION['user']['id']);
                $success = "Hasło zostało zmienione";
            }else{
                $error = "Hasła nie są takie same";
            }
        } else{
            $error = "Niepoprawne stare hasło";
        }
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
    <title>Zmień hasło - Niepubliczne Przedszkole "Małe Skrzaty" w Łodzi</title>

    <style>
        .login-form{
            padding: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .login-form form{
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 24px;
        }

        .login-form form label{
            color: var(--input);
            font-size: 20px;
        }

        .login-form form input, .login-form form button{
            width: 400px;
            font-size: 20px;
            border: none;
            padding: 8px;
            color: var(--input);
            border-radius: 10px;
            
        }

        .login-form form input::placeholder{
            color: #B0B0B0;
        }

        .login-form form button[type="submit"]{
            background-color: var(--text);
            font-family: "Aclonica", sans-serif;
            color: #fff;
        }

        .error-message {
            display: block;
            background-color: #ffcccc;
            color: #c00;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #c00;
        }
        .success-message {
            display: block;
            background-color: #ccffcc;
            color: #060;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #060;
        }
    </style>

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
                <div class="nav__link"><a href="wiadomosci.php">Wiadomości</a></div>
                <div class="nav__link current"><a href="zmien-haslo.php">Zmień hasło</a></div>
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
                <div class="nav__link"><a href="wiadomosci.php">Wiadomości</a></div>
                <div class="nav__link"><a href="zmien-haslo.php">Zmień hasło</a></div>
                <div class="nav__link logout"><a href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Wyloguj się</a></div>
            </div>
            <?php
            }
            ?>
        </nav>
    
        <main>
            <h2>Zmień hasło</h2>
            <div class="login-form">
                <form method="post">
                    <label for="old-password">Stare hasło:</label>
                    <input type="password" id="old-password" name="old_password">
                    <label for="new-password1">Nowe hasło:</label>
                    <input type="password" id="new-password1" name="new_password1">
                    <label for="new-password2">Powtórz nowe hasło:</label>
                    <input type="password" id="new-password2" name="new_password2">
                    <button type="submit" name="change_password">Zmień hasło</button>
                </form>
            </div>
            
            <?php
                if (isset($error)){
                    echo "<span class='error-message'>$error</span>";
                    unset($error);
                }

                if(isset($success)){
                    echo "<span class='success-message'>$success</span>";
                    unset($success);
                }
            ?>
        </main>
    </div>
</body>
</html>

<?php
    $conn->close();
?>