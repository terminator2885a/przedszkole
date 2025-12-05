<?php
    session_start();

    require_once 'db/connect.php';
    $conn = new mysqli($host, $user, $pass, $db);

    $logged = false;
    if(isset($_SESSION['parent'])) $logged = true;

    if(isset($_POST['message'])){
        $from = sprintf("p%03d", $_SESSION['parent']['preschooler_id']);
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