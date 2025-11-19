<?php
    session_start();
    if(!isset($_SESSION['user'])) {header('Location: login-page.php'); exit();}
    if($_SESSION['user']['rank'] != 1) {echo '<script>alert("Nie masz uprawnień");</script>'; header('Location: index.php'); exit();}

    require_once '../db/connect.php';
    $conn = new mysqli($host, $user, $pass, $db);
    mysqli_set_charset($conn, 'utf8mb4');

    $preschooler_id = $_GET['preschooler_id'];

    $result = $conn->query("DELETE FROM przedszkolaki WHERE id_przedszkolaka='" . $preschooler_id . "'") or die('<script>alert("Nie można usunać nauczyciela. Upewnij się, że usunąłeś go z roli wychowawcy"); window.location.href="nauczyciele.php";</script>');

    $conn->close();

    header('Location: przedszkolaki.php');
?>