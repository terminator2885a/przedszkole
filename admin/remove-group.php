<?php
    session_start();
    if(!isset($_SESSION['user'])) {header('Location: login-page.php'); exit();}
    if($_SESSION['user']['rank'] != 1) {echo '<script>alert("Nie masz uprawnień");</script>'; header('Location: index.php'); exit();}

    require_once '../db/connect.php';
    $conn = new mysqli($host, $user, $pass, $db);
    mysqli_set_charset($conn, 'utf8mb4');

    $group_id = $_GET['group_id'];

    $result = $conn->query("DELETE FROM grupy WHERE id_grupy='" . $group_id . "'") or die('<script>alert("Nie można usunąć grupy."); window.location.href="przeglad-grup.php";</script>');

    $conn->close();

    header('Location: przeglad-grup.php');
?>