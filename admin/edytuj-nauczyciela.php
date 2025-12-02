<?php
    session_start();
    if(!isset($_SESSION['user'])) {header('Location: login-page.php'); exit();}
    if($_SESSION['user']['rank'] != 1) {echo '<script>alert("Nie masz uprawnień");</script>'; header('Location: index.php'); exit();}

    require_once '../db/connect.php';
    $conn = new mysqli($host, $user, $pass, $db);
    mysqli_set_charset($conn, 'utf8mb4');

    $edit = false;
    $teacher_id = null;
    $l_name = '';
    $f_name = '';
    $pesel = '';
    $rank = '';
    $phone = '';
    $e_mail = '';
    $login = '';

    if(isset($_GET['teacher_id'])){
        $edit = true;
        $teacher_id = $_GET['teacher_id'];
        
        $query = "SELECT * FROM nauczyciele WHERE id_nauczyciela=" . $teacher_id;
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        
        $l_name = $row['nazwisko'];
        $f_name = $row['imie'];
        $pesel = $row['pesel'];
        $rank = $row['ranga'];
        $phone = $row['nr_telefonu'];
        $e_mail = $row['e_mail'];
        $login = $row['login'];
        
        $result->free_result();
    }

    // $query_teachers = "SELECT id_nauczyciela, imie, nazwisko FROM nauczyciele";
    // $result_teachers = $conn->query($query_teachers);
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
    <title><?php echo $edit ? 'Edytuj nauczyciela' : 'Dodaj nauczyciela'; ?> - Dyrektor w Niepublicznym Przedszkolu "Małe Skrzaty" w Łodzi</title>
</head>
<body>
    <div class="page">
        <header>
            <h1>Niepubliczne przedszkole "Małe Skrzaty" w Łodzi</h1>
        </header>
    
        <div class="teacher-banner">

            <?php
                require_once 'functions.php';
                echo '<div class="img teacher-banner__img">';
                echo '<img src="../img/teachers/' . removePolishCharacters(strtolower($_SESSION['user']['f_name'] . '_' . $_SESSION['user']['l_name'] . '.jpg">'));
                echo '</div>';

                echo '<h3>' . $_SESSION['user']['f_name'] . ' ' . $_SESSION['user']['l_name'] . '</h3>';
                echo '<h4>Dyrektor przedszkola</h4>';
            ?>
        </div>

        <nav>
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
                <div class="nav__link dropdown current">
                    Nauczyciele
                    <ul>
                        <li><a href="nauczyciele.php">Przegląd</a></li>
                        <li class="current"><a href="dodaj-nauczyciela.php">Dodaj</a></li>
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
        </nav>

        <main>
            <h2><?php echo $edit ? 'Edytuj nauczyciela' : 'Dodaj nauczyciela'; ?></h2>

            <form method="post" action="<?php echo $edit ? 'add-teacher.php?teacher_id=' . $teacher_id : 'add-teacher.php'; ?>">
                <label for="l-name">Nazwisko:</label>
                <input type="text" id="l-name" name="l_name" value="<?php echo $l_name; ?>" required>

                <label for="f-name">Imię:</label>
                <input type="text" id="f-name" name="f_name" value="<?php echo $f_name; ?>" required>

                <label for="pesel">Numer PESEL:</label>
                <input type="text" id="pesel" name="pesel" value="<?php echo $pesel; ?>" required>                

                <label for="rank">Stanowisko:</label>
                <select id="rank" name="rank">
                    <option value="">-- Brak --</option>
                    <?php
                        $result_rank = $conn->query("SELECT * FROM rangi");
                        while($rank_row = $result_rank->fetch_assoc()) {
                            $selected = ($rank_row['id_rangi'] == $rank) ? 'selected' : '';
                            echo '<option value="' . $rank_row['id_rangi'] . '" ' . $selected . '>' . $rank_row['nazwa_rangi'] . '</option>';
                        }
                    ?>nauczyciela
                </select>

                <label for="phone">Numer telefonu:</label>
                <input type="tel" pattern="[0-9]{9}" maxlength="9" id="phone" name="phone" value="<?php echo $phone; ?>" required>
                
                <label for="e-mail">Adres e-mail:</label>
                <input type="email" id="e-mail" name="e_mail" value="<?php echo $e_mail; ?>" required>

                <label for="login">Login:</label>
                <input type="text" id="login" name="login" value="<?php echo $login; ?>" required>

                <div class="form-buttons">
                    <button type="submit"><?php echo $edit ? 'Zapisz zmiany' : 'Dodaj nauczyciela'; ?></button>
                    <a href="nauczyciele.php" class="form-cancel">Anuluj</a>
                </div>
            </form>
        </main>

    </div>
</body>
</html>

<?php
    $conn->close();
?>
