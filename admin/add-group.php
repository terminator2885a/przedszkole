<?php
    session_start();
    if(!isset($_SESSION['user'])) {header('Location: login-page.php'); exit();}
    if($_SESSION['user']['rank'] != 1) {header('Location: index.php'); exit();}

    require_once '../db/connect.php';
    $conn = new mysqli($host, $user, $pass, $db);
    mysqli_set_charset($conn, 'utf8mb4');

    if(isset($_POST['group_name'])){
        $edit = false;
        $group_id = null;
        
        if(isset($_GET['id_grupy'])){
            $edit = true;
            $group_id = $_GET['id_grupy'];
        }

        $group_name = $_POST['group_name'];
        $group_desc = $_POST['group_desc'] ?? '';
        $teacher1_id = $_POST['teacher1_id'] ?: null;
        $teacher2_id = $_POST['teacher2_id'] ?: null;

        if($edit){
            $query = $conn->prepare("UPDATE grupy SET nazwa_grupy=?, opis_grupy=?, wychowawca1=?, wychowawca2=? WHERE id_grupy=?");
            $query->bind_param("ssiii", $group_name, $group_desc, $teacher1_id, $teacher2_id, $group_id);
            $query->execute();
            $query->close();
        }
        else{
            $query = $conn->prepare("INSERT INTO grupy (nazwa_grupy, opis_grupy, wychowawca1, wychowawca2) VALUES (?, ?, ?, ?)");
            $query->bind_param("ssii", $group_name, $group_desc, $teacher1_id, $teacher2_id);
            $query->execute();
            $group_id = $conn->insert_id;
            $query->close();
        }
    }

    $conn->close();
    header('Location: przeglad-grup.php');
?>
