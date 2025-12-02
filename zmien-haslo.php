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


    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $row = $conn->query("SELECT * FROM przedszkolaki WHERE id_przedszkolaka=". $_SESSION['parent']['preschooler_id'])->fetch_assoc();

        if(password_verify($_POST['old_password'], $row['password'])){
            if($_POST['new_password1'] == $_POST['new_password2']){
                $hashedPassword = password_hash($_POST['new_password1'], PASSWORD_DEFAULT);
                $conn->query("UPDATE przedszkolaki SET password='$hashedPassword' WHERE id_przedszkolaka=".$_SESSION['parent']['preschooler_id']);
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
    <link rel="stylesheet" href="css/style.css">
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
                <div class="aside__link current"><a href="rodzic.php">Komunikaty dyrekcji</a></div>
                <div class="aside__link"><a href="jadlospis.php">Jadłospis</a></div>
                <?php
                if(!$logged){
                ?>
                <div class="aside__link"><a href="rodzic-login.php">Zaloguj się</a></div>
                <?php } else { ?>
                <div class="aside__link"><a href="dziecko.php">Informacje o dziecku</a></div>
                <div class="aside__link"><a href="wiadomosci.php">Wiadomości</a></div>
                <div class="aside__link"><a href="zmien-haslo.php">Zmień hasło</a></div>
                <div class="aside__link logout"><a href="rodzic-logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Wyloguj się</a></div>
                <?php } ?>
            </aside>
            <article>
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