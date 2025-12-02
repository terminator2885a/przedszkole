<?php
session_start();
if (!isset($_SESSION['user'])) { header('Location: login-page.php'); exit(); }
if ($_SESSION['user']['rank'] != 1) { header('Location: index.php'); exit(); }

require_once '../db/connect.php';
require_once 'functions.php';

$conn = new mysqli($host, $user, $pass, $db);
mysqli_set_charset($conn, 'utf8mb4');

if (isset($_POST['l_name'])) {
    $edit = false;
    $preschooler_id = null;

    if (isset($_GET['preschooler_id'])) {
        $edit = true;
        $preschooler_id = (int)$_GET['preschooler_id'];
    }

    $l_name   = $_POST['l_name'];
    $f_name   = $_POST['f_name'] ?? '';
    $pesel    = $_POST['pesel'] ?? null;
    $group    = $_POST['group'] ?? null;
    $parents  = $_POST['parents'] ?? '';
    $allergens= $_POST['allergens'] ?? '';
    $religion = isset($_POST['religion']) ? (int)$_POST['religion'] : 0;
    $e_mail   = $_POST['e_mail'] ?? '';
    $login    = $_POST['login'] ?? '';

    if ($edit) {
        $stmt = $conn->prepare("UPDATE przedszkolaki SET nazwisko=?, imie=?, pesel=?, grupa=?, imiona_rodzicow=?, alergeny=?, religia=?, e_mail=?, login=? WHERE id_przedszkolaka=?");
        $stmt->bind_param("sssississi", $l_name, $f_name, $pesel, $group, $parents, $allergens, $religion, $e_mail, $login, $preschooler_id);
        $stmt->execute();
        $stmt->close();
        // $get = 'edit=true';
        $_SESSION['edit'] = true;
    } else {
        $generatedPassword = generatePassword();
        $hashedPassword = password_hash($generatedPassword, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO przedszkolaki (nazwisko, imie, pesel, grupa, imiona_rodzicow, alergeny, religia, e_mail, login, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssississs", $l_name, $f_name, $pesel, $group, $parents, $allergens, $religion, $e_mail, $login, $hashedPassword);
        $stmt->execute();
        $preschooler_id = $conn->insert_id;
        $stmt->close();
        // $get = 'add=true';
        $_SESSION['add'] = true;
        $_SESSION['password'] = $generatedPassword;
    }
}

$conn->close();
header("Location: przedszkolaki.php?" . $get);
exit();
?>