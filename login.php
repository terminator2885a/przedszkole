<?php
    session_start();
    if(isset($_SESSION['parent'])) {header('Location: rodzic.php'); exit();}


    if(isset($_POST['login'])){
        require_once 'db/connect.php';
        $conn = @new mysqli($host, $user, $pass, $db);
        mysqli_set_charset($conn, 'utf8mb4');

        $login = htmlentities($_POST['login'], ENT_QUOTES, "UTF-8");
		$password = htmlentities($_POST['password'], ENT_QUOTES, "UTF-8");

        if ($result = $conn->query(
			sprintf("SELECT * FROM przedszkolaki WHERE login='%s'",
			mysqli_real_escape_string($conn,$login)))){
                $row = $result->fetch_assoc();

                if(password_verify($password, $row['password'])){
                    $_SESSION['parent'] = array(
                        'preschooler_id' => $row['id_przedszkolaka'],
                        'l_name' => $row['nazwisko'],
                        'f_name' => $row['imie'],
                        'pesel' => $row['pesel'],
                        'group' => $row['grupa'],
                        'parents' => $row['imiona_rodzicow'],
                        'allergens' => $row['alergeny'],
                        'religion' => $row['religia'],
                        'phone' => $row['nr_telefonu'],
                        'e_mail' => $row['e_mail'],
                    );

                    unset($_SESSION['err']);
					$result->free_result();
                    header('Location: rodzic.php');
                    exit();
                }else{
                    $_SESSION['err'] = 'Nieprawidłowy login lub hasło!';
					header('Location: rodzic-login.php');
                }
            }
            $conn->close();
    }else{
        header('Location: rodzic.php');
    }

?>