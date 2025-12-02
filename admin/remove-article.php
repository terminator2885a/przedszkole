<?php
    session_start();
    if(!isset($_SESSION['user'])) {header('Location: login-page.php'); exit();}
    if($_SESSION['user']['rank'] != 1) {echo '<script>alert("Nie masz uprawnień");</script>'; header('Location: index.php'); exit();}

    require_once '../db/connect.php';
    $conn = new mysqli($host, $user, $pass, $db);
    mysqli_set_charset($conn, 'utf8mb4');

    $article_id = $_GET['article_id'];

    $result = $conn->query("DELETE FROM artykuly WHERE id_artykulu='" . $article_id . "'") or die('<script>alert("Wystąpił błąd, nie można usunąć komunikatu"); window.location.href="komunikat.php";</script>');

    $conn->close();

    header('Location: artykul.php');
?>