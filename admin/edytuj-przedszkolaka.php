<?php
session_start();
if (!isset($_SESSION['user'])) { header('Location: login-page.php'); exit(); }
if ($_SESSION['user']['rank'] != 1) { echo '<script>alert("Nie masz uprawnień");</script>'; header('Location: index.php'); exit(); }

require_once '../db/connect.php';
$conn = new mysqli($host, $user, $pass, $db);
mysqli_set_charset($conn, 'utf8mb4');

$edit = false;
$preschooler_id = null;
$l_name = '';
$f_name = '';
$pesel = '';
$group = '';
$parents = '';
$allergens = '';
$religion = 0;
$e_mail = '';
$login = '';

if (isset($_GET['preschooler_id'])) {
    $edit = true;
    $preschooler_id = (int)$_GET['preschooler_id'];

    $query = "SELECT * FROM przedszkolaki WHERE id_przedszkolaka=" . $preschooler_id;
    $result = $conn->query($query);
    $row = $result->fetch_assoc();

    $l_name   = $row['nazwisko'];
    $f_name   = $row['imie'];
    $pesel    = $row['pesel'];
    $group    = $row['grupa'];
    $parents  = $row['imiona_rodzicow'];
    $allergens= $row['alergeny'];
    $religion = $row['religia'];
    $e_mail   = $row['e_mail'];
    $login    = $row['login'];

    $result->free_result();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?php echo $edit ? 'Edytuj przedszkolaka' : 'Dodaj przedszkolaka'; ?> - Dyrektor</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
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
                <div class="nav__link dropdown current">
                    Przedszkolaki
                    <ul>
                        <li><a href="przedszkolaki.php">Przegląd</a></li>
                        <li class="current"><a href="edytuj-przedszkolaka.php">Dodaj</a></li>
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
        </nav>

        <main>
            <h2><?php echo $edit ? 'Edytuj przedszkolaka' : 'Dodaj przedszkolaka'; ?></h2>

            <form method="post" action="<?php echo $edit ? 'add-preschooler.php?preschooler_id=' . $preschooler_id : 'add-preschooler.php'; ?>">
                <label for="l-name">Nazwisko:</label>
                <input type="text" id="l-name" name="l_name" value="<?php echo $l_name; ?>" required>

                <label for="f-name">Imię:</label>
                <input type="text" id="f-name" name="f_name" value="<?php echo $f_name; ?>" required>

                <label for="pesel">PESEL:</label>
                <input type="text" id="pesel" name="pesel" value="<?php echo $pesel; ?>" required>

                <label for="group">Grupa:</label>
                <select id="group" name="group" required>
                    <option value="">-- Wybierz grupę --</option>
                    <?php
                        $result_groups = $conn->query("SELECT * FROM grupy");
                        while($group_row = $result_groups->fetch_assoc()) {
                            $selected = ($group_row['id_grupy'] == $group) ? 'selected' : '';
                            echo '<option value="' . $group_row['id_grupy'] . '" ' . $selected . '>' . $group_row['nazwa_grupy'] . '</option>';
                        }
                    ?>
                </select>

                <label for="parents">Imiona rodziców:</label>
                <input type="text" id="parents" name="parents" value="<?php echo $parents; ?>">

                <label for="allergens">Alergeny:</label>
                <input type="text" id="allergens" name="allergens" value="<?php echo $allergens; ?>">

                <label for="religion">Religia:</label>
                <select id="religion" name="religion">
                    <option value="0" <?php echo $religion == 0 ? 'selected' : ''; ?>>Nie</option>
                    <option value="1" <?php echo $religion == 1 ? 'selected' : ''; ?>>Tak</option>
                </select>

                <label for="e-mail">E-mail:</label>
                <input type="email" id="e-mail" name="e_mail" value="<?php echo $e_mail; ?>">

                <label for="login">Login:</label>
                <input type="text" id="login" name="login" value="<?php echo $login; ?>">

                <div class="form-buttons">
                    <button type="submit"><?php echo $edit ? 'Zapisz zmiany' : 'Dodaj przedszkolaka'; ?></button>
                    <a href="przedszkolaki.php" class="form-cancel">Anuluj</a>
                </div>
            </form>
        </main>
    </div>
</body>
</html>

<?php $conn->close(); ?>
