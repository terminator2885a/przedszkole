<?php
    session_start();
    if(isset($_SESSION['user'])) {header('Location: index.php'); exit(); }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Zaloguj się - Niepubliczne Przedszkole "Małe Skrzaty" w Łodzi</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">
</head>
<body>
    <div class="page">
        <header>
            <h1>Niepubliczne Przedszkole "Małe Skrzaty" w Łodzi</h1>
        </header>
    
        <div class="baner">
            <img src="../img/baner1.png" alt="">
        </div>
        <nav style="align-items: start;">
            <div class="nav__link">
                <a href="../index.html"><- Powrót do strony głównej</a>
            </div>
        </nav>
        <main class="login-form">
            <h3>Zaloguj się do panelu nauczyciela</h3>
            <form action="login.php" method="post">
                <label for="login">Login:</label>
                <input type="text" id="login" name="login" placeholder="a0bc1def12">
                <label for="password">Hasło:</label>
                <input type="password" id="password" name="password" placeholder="**********">
                <input type="submit" value="Zaloguj się">
                <?php 
                if(isset($_SESSION['err'])){
                    echo '<span class="error">' . $_SESSION['err'] . '</span>';
                } 
                ?>
            </form>
        </main>
    </div>
</body>
</html>