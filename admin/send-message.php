<?php
    session_start();
    if(!isset($_SESSION['user'])) {header('Location: login-page.php'); exit();}


    // print_r($_SESSION['user']);
    // Nazwa roli
    require_once '../db/connect.php';
    $conn = new mysqli($host, $user, $pass, $db);
    mysqli_set_charset($conn, 'utf8mb4');

    $result = $conn->query('SELECT nazwa_rangi FROM rangi WHERE id_rangi='. $_SESSION['user']['rank']);
    $row = $result->fetch_assoc();
    $_SESSION['user']['rank_name'] = $row['nazwa_rangi'];
    $result->free_result();

    if($_SESSION['user']['rank'] == 2){
        $query = //sprintf("SELECT nazwa_grupy FROM grupy WHERE wychowawca1='%s' OR wychowawca2='%s'", $_SESSION['user']['id'], $_SESSION['user']['id']);
        "SELECT nazwa_grupy FROM grupy WHERE wychowawca1=". $_SESSION['user']['id'] . " OR wychowawca2=" . $_SESSION['user']['id'];

        $result = $conn->query($query);
        if($result->num_rows != 0){
            $row = $result->fetch_assoc();
            $_SESSION['group_name'] = $row['nazwa_grupy'];
        }else{
            $_SESSION['group_name'] = null;
        }
        
        $result->free_result();

    }

    if(isset($_POST['message'])){
        $from = sprintf("n%03d", $_SESSION['user']['id']);
        $to = $_POST['to'];
        $subject = $_POST['subject'];
        $message = sprintf("%s", $_POST['message']);
        $date = date('Y-m-d H:i:s');

        // echo $from; echo "<br>";
        // echo $to; echo "<br>";
        // echo $subject; echo "<br>";
        // echo $message; echo "<br>";
        // echo $date; echo "<br>";

        $query = $conn->prepare("INSERT INTO wiadomosci(data_wyslania, nadawca, odbiorca, temat, tresc) VALUES (?, ?, ?, ?, ?)");
        if($query === false){
            die("Błąd w prepare(): " . $conn->error);
        }
        $query->bind_param('sssss', $date, $from, $to, $subject, $message);
        $query->execute();
        $query->close();
        header('Location: wiadomosci.php');
    }

    $conn->close();
?>