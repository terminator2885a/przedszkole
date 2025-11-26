<?php
    session_start();
    if(!isset($_SESSION['user'])) {header('Location: login-page.php'); exit();}
    if($_SESSION['user']['rank'] != 1) {header('Location: index.php'); exit();}

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(!isset($_POST['tresc_komunikatu']) || empty(trim($_POST['tresc_komunikatu']))){
            header('Location: komunikat.php?error=empty');
            exit();
        }

        require_once '../db/connect.php';
        $conn = new mysqli($host, $user, $pass, $db);
        mysqli_set_charset($conn, 'utf8mb4');

        $content = trim($_POST['tresc_komunikatu']);
        $date = date('Y-m-d');

        $result = $conn->prepare("INSERT INTO komunikaty (data_komunikatu, tresc_komunikatu) VALUES (?, ?)");
        $result->bind_param("ss", $date, $content);
        
        if($result->execute()){
            $result->close();
            $conn->close();
            header('Location: komunikat.php?success=true');
            exit();
        } else {
            $result->close();
            $conn->close();
            header('Location: komunikat.php?error=database');
            exit();
        }
    }

    header('Location: komunikat.php');
    exit();
?>
