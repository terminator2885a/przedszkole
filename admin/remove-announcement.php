<?php
    session_start();
    if(!isset($_SESSION['user'])) {header('Location: login-page.php'); exit();}
    if($_SESSION['user']['rank'] != 1) {echo '<script>alert("Nie masz uprawnień");</script>'; header('Location: index.php'); exit();}

    require_once '../db/connect.php';
    $conn = new mysqli($host, $user, $pass, $db);
    mysqli_set_charset($conn, 'utf8mb4');

    $announcement_id = $_GET['announcement_id'];

    $result = $conn->query("DELETE FROM komunikaty WHERE id_komunikatu='" . $announcement_id . "'") or die('<script>alert("Wystąpił błąd, nie można usunąć komunikatu"); window.location.href="komunikat.php";</script>');

    $conn->close();

    header('Location: komunikat.php');
?>