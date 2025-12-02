<?php
    session_start();
    if(!isset($_SESSION['user'])) {header('Location: login-page.php'); exit();}
    // if($_SESSION['user']['rank'] != 1) {echo '<script>alert("Nie masz uprawnień");</script>'; header('Location: index.php'); exit();}

    require_once '../db/connect.php';
    $conn = new mysqli($host, $user, $pass, $db);
    mysqli_set_charset($conn, 'utf8mb4');

    $edit = false;
    if(isset($_GET['article-id'])){
        $edit = true;
        $article_id = $_GET['article-id'];
    }

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/articles.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php if($_SESSION['user']['rank']==1) {?>
    <title>Artykuły - Dyrektor w Niepublicznym Przedszkolu "Małe Skrzaty" w Łodzi</title>
    <?php } else if($_SESSION['user']['rank']==2){ ?>
    <title>Dodaj artykuł - Wychowawca w Niepublicznym Przedszkolu "Małe Skrzaty" w Łodzi</title>
    <?php }else{ ?>
    <title>Dodaj artykuł - Nauczyciel w Niepublicznym Przedszkolu "Małe Skrzaty" w Łodzi</title>
    <?php } ?>

    <script src="../js/article.js" type="module" defer></script>
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
                <div class="nav__link dropdown current">
                    Wpisy
                    <ul>
                        <li class="current"><a href="artykul.php">Artykuły</a></li>
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
                <div class="nav__link"><a href="index.php">Moja grupa</a></div>
                <div class="nav__link"><a href="przedszkolaki.php">Moje przedszkolaki</a></div>
                <div class="nav__link current"><a href="artykul.php">Dodaj artykuł</a></div>
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
                <div class="nav__link current"><a href="artykul.php">Dodaj artykuł</a></div>
                <div class="nav__link"><a href="wiadomosci.php">Wiadomości</a></div>
                <div class="nav__link logout"><a href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Wyloguj się</a></div>
            </div>
            <?php
            }
            ?>
        </nav>

        <main>
            <h2>Dodaj/edytuj artykuł</h2>

            <div class="articles">
                <div class="input">
                    <button id="article-show-preview">Zobacz podgląd</button>
                    <textarea id="article-content"><?php
                        if($edit){
                            $query = "SELECT tresc_artykulu FROM artykuly WHERE id_artykulu=" . $article_id;
                            $result = $conn->query($query);
                            $row = $result->fetch_assoc();
                            echo $row['tresc_artykulu'];
                        }else{
                            ?>
Tytuł artykułu
-----------------------

### Podtytuł 1

Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus molestie et dui eu imperdiet. Nullam.

### Podtytuł 2

Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus molestie et dui eu imperdiet. Nullam.
                            <?php
                        }
                    ?></textarea>
                </div>
                <form <?php 
                if($edit) echo 'action="add-article.php?article-id=' . $article_id . '"'; 
                else echo 'action="add-article.php"';
                 ?> class="previev" method="post">
                    <input type="submit" value="Zapisz zmiany" id="save-changes">
                    <div id="article-preview"></div>
                    <textarea name="article-content" id="hidden-article-preview" style="display:none;"></textarea>
                </form>
            </div>
        </main>

    </div>
</body>
</html>

<?php
    $conn->close();
?>
