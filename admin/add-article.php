<?php
    session_start();
    if(!isset($_SESSION['user'])) {header('Location: login-page.php'); exit();}
    // if($_SESSION['user']['rank'] != 1) {header('Location: index.php'); exit();}


    require_once '../db/connect.php';
    $conn = new mysqli($host, $user, $pass, $db);
    mysqli_set_charset($conn, 'utf8mb4');

    if(isset($_POST['article-content'])){
        $edit = false;
        if(isset($_GET['article-id'])){
            $edit = true;
            $article_id = $_GET['article-id'];
        }

        $article_content = $_POST['article-content'];


        $start = strpos($article_content, '<h2>') + 4;
        $end = strpos($article_content, '</h2>');

        $article_title = substr($article_content, $start, $end - $start);
        if($edit){
            $query = sprintf("UPDATE artykuly SET tytul_artykulu='%s', tresc_artykulu='%s' WHERE id_artykulu=%d", $article_title, $article_content, $article_id);
            $conn->query($query);
        }
        else{
            $query = sprintf("INSERT INTO artykuly (autor_artykulu, tytul_artykulu, tresc_artykulu) VALUES (%d, '%s', '%s')", $_SESSION['user']['id'], $article_title, $article_content);
            $conn->query($query);
            $article_id = $conn->query("SELECT id_artykulu FROM artykuly ORDER BY id_artykulu DESC LIMIT 1")->fetch_assoc()['id_artykulu'];
        }


    }

    $conn->close();
    header('Location: edytuj-artykul.php?article-id='.$article_id);

?>