<?php
    session_start();
    if(!isset($_SESSION['user'])) {header('Location: login-page.php'); exit();}
    if($_SESSION['user']['rank'] != 1) {header('Location: index.php'); exit();}

    require_once '../db/connect.php';
    require_once 'functions.php';
    $conn = new mysqli($host, $user, $pass, $db);
    mysqli_set_charset($conn, 'utf8mb4');

    if(isset($_POST['l_name'])){
        $edit = false;
        $teacher_id = null;
        
        if(isset($_GET['teacher_id'])){
            $edit = true;
            $teacher_id = $_GET['teacher_id'];
        }

        $l_name = $_POST['l_name'];
        $f_name = $_POST['f_name'] ?? '';
        $pesel = $_POST['pesel'] ?: null;
        $rank = $_POST['rank'] ?: null;
        $phone = $_POST['phone'] ?: null;
        $e_mail = $_POST['e_mail'] ?: null;
        $login = $_POST['login'] ?: null;

        if($edit){
            $query = $conn->prepare("UPDATE nauczyciele SET nazwisko=?, imie=?, pesel=?, ranga=?, nr_telefonu=?, e_mail=?, login=? WHERE id_nauczyciela=?");
            $query->bind_param("ssssiss", $l_name, $f_name, $pesel, $rank, $phone, $e_mail, $login);
            $query->execute();
            $query->close();
            $get = 'edit=true';
        }
        else{
            $generatedPassword = generatePassword();
            $query = $conn->prepare("INSERT INTO nauczyciele (nazwisko, imie, pesel, ranga, nr_telefonu, e_mail, login, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $query->bind_param(
                'sssissss',
                $l_name,
                $f_name,
                $pesel,
                $rank,
                $phone,
                $e_mail,
                $login,
                password_hash($generatedPassword, PASSWORD_DEFAULT)
            );
            $query->execute();
            $teacher_id = $conn->insert_id;
            $query->close();
            $get = 'add=true';
            $_SESSION['password'] = $generatedPassword; 
        }
    }

    $conn->close();
    header("Location: nauczyciele.php?" . $get);
?>
