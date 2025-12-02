<?php
    session_start();
    if(!isset($_SESSION['user'])) {header('Location: login-page.php'); exit();}
    if($_SESSION['user']['rank'] != 1) {echo '<script>alert("Nie masz uprawnień");</script>'; header('Location: index.php'); exit();}

    require_once '../db/connect.php';
    $conn = new mysqli($host, $user, $pass, $db);
    mysqli_set_charset($conn, 'utf8mb4');

    $edit = false;
    $group_id = null;
    $group_name = '';
    $group_desc = '';
    $teacher1_id = '';
    $teacher2_id = '';

    if(isset($_GET['id_grupy'])){
        $edit = true;
        $group_id = $_GET['id_grupy'];
        
        $query = "SELECT nazwa_grupy, opis_grupy, wychowawca1, wychowawca2 FROM grupy WHERE id_grupy=" . $group_id;
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        
        $group_name = $row['nazwa_grupy'];
        $group_desc = $row['opis_grupy'];
        $teacher1_id = $row['wychowawca1'];
        $teacher2_id = $row['wychowawca2'];
        $result->free_result();
    }

    $query_teachers = "SELECT id_nauczyciela, imie, nazwisko FROM nauczyciele";
    $result_teachers = $conn->query($query_teachers);
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
    <title><?php echo $edit ? 'Edytuj grupę' : 'Dodaj grupę'; ?> - Dyrektor w Niepublicznym Przedszkolu "Małe Skrzaty" w Łodzi</title>
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
                <div class="nav__link current"><a href="index.php">Grupy</a></div>
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
                <div class="nav__link"><a href="zmien-haslo.php">Zmień hasło</a></div>
                <div class="nav__link logout"><a href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Wyloguj się</a></div>
            </div>
        </nav>

        <main>
            <h2><?php echo $edit ? 'Edytuj grupę' : 'Dodaj grupę'; ?></h2>

            <form method="post" action="<?php echo $edit ? 'add-group.php?id_grupy=' . $group_id : 'add-group.php'; ?>">
                <label for="group-name">Nazwa grupy:</label>
                <input type="text" id="group-name" name="group_name" value="<?php echo $group_name; ?>" required>

                <label for="group-desc">Opis grupy:</label>
                <textarea id="group-desc" name="group_desc"><?php echo $group_desc; ?></textarea>

                <label for="teacher1">Wychowawca 1:</label>
                <select id="teacher1" name="teacher1_id">
                    <option value="">-- Brak --</option>
                    <?php
                        while($teacher_row = $result_teachers->fetch_assoc()){
                            $selected = ($teacher_row['id_nauczyciela'] == $teacher1_id) ? 'selected' : '';
                            echo '<option value="' . $teacher_row['id_nauczyciela'] . '" ' . $selected . '>' . $teacher_row['imie'] . ' ' . $teacher_row['nazwisko'] . '</option>';
                        }
                    ?>
                </select>

                <label for="teacher2">Wychowawca 2:</label>
                <select id="teacher2" name="teacher2_id">
                    <option value="">-- Brak --</option>
                    <?php
                        $result_teachers->data_seek(0);
                        while($teacher_row = $result_teachers->fetch_assoc()){
                            $selected = ($teacher_row['id_nauczyciela'] == $teacher2_id) ? 'selected' : '';
                            echo '<option value="' . $teacher_row['id_nauczyciela'] . '" ' . $selected . '>' . $teacher_row['imie'] . ' ' . $teacher_row['nazwisko'] . '</option>';
                        }
                    ?>
                </select>

                <div class="form-buttons">
                    <button type="submit"><?php echo $edit ? 'Zapisz zmiany' : 'Dodaj grupę'; ?></button>
                    <a href="przeglad-grup.php" class="form-cancel">Anuluj</a>
                </div>
            </form>
        </main>

    </div>
</body>
</html>

<?php
    $conn->close();
?>
