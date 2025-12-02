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

    <style>
        .error-message {
            background-color: #ffcccc;
            color: #c00;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #c00;
        }
        .success-message {
            background-color: #ccffcc;
            color: #060;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #060;
        }
    </style>

    <title>Przegląd nauczycieli - Dyrektor w Niepublicznym Przedszkolu "Małe Skrzaty" w Łodzi</title>
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
                        <li class="current"><a href="nauczyciele.php">Przegląd</a></li>
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
            <h2>Przegląd nauczycieli</h2>

            <?php
                if(isset($_GET['add'])){
                    echo '<div class="success-message">Nauczyciel został dodany. Jego nowe hasło to: '. $_SESSION['password'] . '</div>';
                    unset($_SESSION['password']);
                }elseif(isset($_GET['edit'])){
                    echo '<div class="success-message">Zmiany zostały zapisane.</div>';
                }

                $all = false;
                if(isset($_GET['all'])){
                    $all = $_GET['all'] == 'true';
                }
                $query = "SELECT * FROM nauczyciele JOIN rangi ON nauczyciele.ranga=rangi.id_rangi";
                $result = $conn->query($query);
            ?>

            <div class="data_show_hide">
                <?php if($all==true){ ?>
                    <a href="?all=false">Pokaż mniej danych</a>
                <?php } else{ ?>
                    <a href="?all=true">Pokaż wszystkie dane</a>
                <?php } ?>
            </div>
            
            <table id="teachers__table">
                <tr>
                    <th>Nr</th>
                    <th>Nazwisko</th>
                    <th>Imię</th>
                    <th>Stanowisko</th>
                    <?php if($all==true){ ?>
                    <th>Pesel</th>
                    <th>Nr telefonu</th>
                    <th>Adres e-mail</th>
                    <th>Login</th>
                    <?php } ?>
                    <th>Edytuj dane</th>
                    <th>Usuń nauczyciela</th>
                </tr>
                
                <?php
                    while($row = $result->fetch_assoc()){
                        echo '<tr>';
                        echo '<td>' . $row['id_nauczyciela'] . '</td>';
                        echo '<td>' . $row['nazwisko'] . '</td>';
                        echo '<td>' . $row['imie'] . '</td>';
                        if($row['ranga'] != 2)
                            echo '<td>' . $row['nazwa_rangi'] . '</td>';
                        else{
                            $query2 = "SELECT nazwa_grupy FROM grupy WHERE wychowawca1=". $row['id_nauczyciela'] . " OR wychowawca2=" . $row['id_nauczyciela'];

                            $result2 = $conn->query($query2);

                            $groups = array();
                            if($result2->num_rows >= 1){
                                while($temp = $result2->fetch_assoc()) {
                                    $groups[] = $temp['nazwa_grupy'];
                                }
                            }else{
                                $groups[] = 'brak wychowawstwa';
                            }
                            echo '<td>wychowawca ('. implode(', ', $groups)  . ')</td>'; 

                            $result2->free_result();
                        }

                        if($all==true){
                             echo '<td>' . $row['pesel'] . '</td>';
                             echo '<td>' . $row['nr_telefonu'] . '</td>';
                             echo '<td>' . $row['e_mail'] . '</td>';
                             echo '<td>' . $row['login'] . '</td>';
                        }
                        echo '<td><a href="edytuj-nauczyciela.php?teacher_id=' . $row['id_nauczyciela'] . '">Edytuj dane</a></td>';
                        if($row['ranga']!=1) echo '<td class="remove"><a href="remove-teacher.php?teacher_id=' . $row['id_nauczyciela'] . '">Usuń nauczyciela</a>';
                        else echo '<td></td>';
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