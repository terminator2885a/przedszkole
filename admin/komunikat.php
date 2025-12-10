<?php
    session_start();
    if(!isset($_SESSION['user'])) {header('Location: login-page.php'); exit();}
    if($_SESSION['user']['rank'] != 1) {echo '<script>alert("Nie masz uprawnień");</script>'; header('Location: index.php'); exit();}

    require_once '../db/connect.php';
    $conn = new mysqli($host, $user, $pass, $db);
    mysqli_set_charset($conn, 'utf8mb4');

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
    <title>Komunikaty - Dyrektor w Niepublicznym Przedszkolu "Małe Skrzaty" w Łodzi</title>

    <script type="module" src="../js/announcement.js"></script>
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
                <div class="nav__link dropdown">
                    Nauczyciele
                    <ul>
                        <li><a href="nauczyciele.php">Przegląd</a></li>
                        <li><a href="edytuj-nauczyciela.php">Dodaj</a></li>
                    </ul>
                </div>
                <div class="nav__link dropdown current">
                    Wpisy
                    <ul>
                        <li><a href="artykul.php">Artykuły</a></li>
                        <li class="current"><a href="komunikat.php">Komunikaty</a></li>
                    </ul>
                </div>
                <div class="nav__link"><a href="wiadomosci.php">Wiadomości</a></div>
                <div class="nav__link"><a href="zmien-haslo.php">Zmień hasło</a></div>
                <div class="nav__link logout"><a href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Wyloguj się</a></div>
            </div>
        </nav>

        <main>
            <h2><i class="fa-solid fa-circle-plus"></i> Dodaj komunikat</h2>

            <form method="post" action="add-announcement.php" class="add-form">
                <label for="tresc_komunikatu">Treść komunikatu:</label>
                <textarea id="tresc_komunikatu" name="tresc_komunikatu" required></textarea>
                <button type="submit" id="add_announcement"><i class="fa-solid fa-circle-plus"></i> Dodaj komunikat</button>
            </form>

            <?php
                $query = "SELECT id_komunikatu, data_komunikatu, tresc_komunikatu FROM komunikaty";
                $result = $conn->query($query);
            ?>
            <h2>Poprzednie komunikaty</h2>
            <table id="announcements__table">
                <tr>
                    <th>ID</th>
                    <th>Data</th>
                    <th>Treść komunikatu</th>
                    <th>Usuń komunikat</th>
                </tr>
                
                <?php
                    while($row = $result->fetch_assoc()){
                        echo '<tr>';
                        echo '<td>' . $row['id_komunikatu'] . '</td>';
                        echo '<td class="date">' . $row['data_komunikatu'] . '</td>';
                        echo '<td>' . $row['tresc_komunikatu'] . '</td>';
                        echo '<td class="remove"><a href="remove-announcement.php?announcement_id=' . $row['id_komunikatu'] . '">Usuń komunikat</a>';
                        echo '</tr>';
                    }
                ?>

            </table>
        </main>

    </div>
</body>
</html>

<?php
    $conn->close();
?>
