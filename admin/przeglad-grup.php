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
    <title>Przegląd grup - Dyrektor w Niepublicznym Przedszkolu "Małe Skrzaty" w Łodzi</title>
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
            <!-- <p><b style="color: red;">Ważne:</b> Strona przedszkola nie jest od zarządzania sprawami kadrowymi. Przedszkolny system oferuje zarządzanie grupami oraz przedszkolakami. Do spraw takich jak urlopy, zwolnienia, płace, należy skorzystać z innych narzędzi.</p> -->
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
            <h2>Przegląd grup</h2>

            <?php
                $query = "SELECT id_grupy, nazwa_grupy, wychowawca1 AS id_wychowawcy1, CONCAT(n1.imie, ' ', n1.nazwisko) AS wychowawca1, wychowawca2 AS id_wychowawcy2, CONCAT(n2.imie, ' ', n2.nazwisko) AS wychowawca2 FROM grupy LEFT JOIN nauczyciele n1 ON wychowawca1=n1.id_nauczyciela LEFT JOIN nauczyciele n2 ON wychowawca2=n2.id_nauczyciela";
                $result = $conn->query($query);
            ?>

            
            <table id="teachers__table">
                <tr>
                    <th>Nr</th>
                    <th>Nazwa grupy</th>
                    <th>Wychowawca 1</th>
                    <th>Wychowawca 2</th>
                    <th>Edytuj grupę</th>
                    <th>Usuń grupę</th>
                </tr>

                <td colspan="6" class="new"><a href="edytuj-grupe.php"><i class="fa-solid fa-circle-plus"></i> Utwórz grupę</a></td>
                
                <?php
                    while($row = $result->fetch_assoc()){
                        echo '<tr>';
                        echo '<td>' . $row['id_grupy'] . '</td>';
                        echo '<td>' . $row['nazwa_grupy'] . '</td>';
                        echo '<td>' . $row['wychowawca1'] . '</td>';
                        echo '<td>' . $row['wychowawca2'] . '</td>';
                        echo '<td class="edit"><a href="edytuj-grupe.php?id_grupy='. $row['id_grupy'] .'">Edytuj grupę</a></td>';
                        echo '<td class="remove"><a href="remove-group.php?group_id='. $row['id_grupy'] .'">Usuń grupę</a></td>';
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