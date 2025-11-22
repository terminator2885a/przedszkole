<?php
require_once 'db/connect.php';

$conn = new mysqli($host, $user, $pass, $db);
mysqli_set_charset($conn, 'utf8mb4');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = htmlspecialchars($_POST['imie'] ?? '');
    $last_name = htmlspecialchars($_POST['nazwisko'] ?? '');
    $pesel = htmlspecialchars($_POST['pesel'] ?? '');
    $imie_mamy = htmlspecialchars($_POST['imie_mamy'] ?? '');
    $nazwisko_mamy = htmlspecialchars($_POST['nazwisko_mamy'] ?? '');
    $imie_taty = htmlspecialchars($_POST['imie_taty'] ?? '');
    $nazwisko_taty = htmlspecialchars($_POST['nazwisko_taty'] ?? '');
    $nr_telefonu_mamy = htmlspecialchars($_POST['nr_telefonu_mamy'] ?? '');
    $nr_telefonu_taty = htmlspecialchars($_POST['nr_telefonu_taty'] ?? '');
    $email_mamy = htmlspecialchars($_POST['email_mamy'] ?? '');
    $email_taty = htmlspecialchars($_POST['email_taty'] ?? '');

    if (empty($first_name) || empty($last_name) || empty($pesel)) {
        $error = "Proszę wypełnić wszystkie wymagane pola (imię, nazwisko, PESEL).";
    } else {
        $generated_login = strtolower($first_name[0] . $last_name);
        $login_counter = 1;
        $original_login = $generated_login;
        
        while ($conn->query("SELECT * FROM przedszkolaki WHERE login='$generated_login'")->num_rows > 0) {
            $generated_login = $original_login . $login_counter;
            $login_counter++;
        }
        
        $generated_password = bin2hex(random_bytes(8));
        
        $query_groups = "SELECT id_grupy FROM grupy LIMIT 1";
        $result_groups = $conn->query($query_groups);
        $group_row = $result_groups->fetch_assoc();
        $generated_group = $group_row['id_grupy'] ?? 1;
        
        $query = "INSERT INTO przedszkolaki (imie, nazwisko, pesel, imie_mamy, nazwisko_mamy, imie_taty, nazwisko_taty, nr_telefonu_mamy, nr_telefonu_taty, email_mamy, email_taty, login, password, grupa) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            $error = "Błąd przygotowania zapytania: " . $conn->error;
        } else {
            $hashed_password = password_hash($generated_password, PASSWORD_DEFAULT);
            
            $stmt->bind_param(
                "sssssssssssssi",
                $first_name,
                $last_name,
                $pesel,
                $imie_mamy,
                $nazwisko_mamy,
                $imie_taty,
                $nazwisko_taty,
                $nr_telefonu_mamy,
                $nr_telefonu_taty,
                $email_mamy,
                $email_taty,
                $generated_login,
                $hashed_password,
                $generated_group
            );
            
            if ($stmt->execute()) {
                $success = "Dziecko zostało pomyślnie zarejestrowane!<br>Login: <strong>$generated_login</strong><br>Hasło tymczasowe: <strong>$generated_password</strong>";
            } else {
                $error = "Błąd podczas rejestracji: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">
    <style>
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: var(--text);
            font-weight: bold;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }
        .form-group input:focus, .form-group textarea:focus {
            outline: none;
            border-color: var(--text);
            box-shadow: 0 0 5px var(--bg-primary);
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .form-row-full {
            grid-column: 1 / -1;
        }
        .required::after {
            content: ' *';
            color: red;
        }
        .submit-btn {
            background-color: var(--bg-primary);
            color: #fff;
            padding: 12px 30px;
            border: none;
            border-radius: 20px;
            font-size: 16px;
            cursor: pointer;
            transition: all 200ms;
            text-shadow: 1px 1px 0 #000, -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000;
        }
        .submit-btn:hover {
            background-color: var(--bg-secondary);
            transform: scale(1.05);
        }
        .error-message {
            background-color: #ffcccc;
            color: #c00;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #c00;
        }
        .success-message {
            background-color: #ccffcc;
            color: #060;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #060;
        }
    </style>
    <title>Formularz Rekrutacji - Niepubliczne Przedszkole "Małe Skrzaty" w Łodzi</title>
</head>
<body>
    <div class="page">
        <header>
            <h1>Niepubliczne przedszkole "Małe Skrzaty" w Łodzi</h1>
        </header>
        <div class="banner">
            <img src="img/baner1.png" alt="baner">
        </div>
        <nav>
            <div class="nav__links">
                <div class="nav__link"><a href="index.html">O nas</a></div>
                <div class="nav__link"><a href="grupy.php">Grupy</a></div>
                <div class="nav__link"><a href="wydarzenia.php">Wydarzenia</a></div>
                <div class="nav__link"><a href="kalendarium.html">Kalendarium</a></div>
                <div class="nav__link"><a href="rodzic.php">Kącik rodzica</a></div>
                <div class="nav__link"><a href="admin/index.php">Panel nauczyciela</a></div>
            </div>
        </nav>
    
        <main>
            <aside>
                <div class="aside__link"><a href="nauczyciele.php">Nasze nauczycielki</a></div>
                <div class="aside__link"><a href="plan_dnia.html">Rozkład dnia</a></div>
                <div class="aside__link current"><a href="rekrutacja.html">Rekrutacja</a></div>
                <div class="aside__link"><a href="rodo.html">Ochrona danych osobowych</a></div>
                <div class="aside__link"><a href="maloletni.html">Standardy ochrony małoletnich</a></div>
                <div class="aside__link"><a href="https://bip.gov.pl">Biuletyn informacji publicznej</a></div>
            </aside>
            <article>
                <h2>Formularz Rekrutacji</h2>
                
                <?php if (!empty($error)): ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if (!empty($success)): ?>
                    <div class="success-message"><?php echo $success; ?></div>
                <?php endif; ?>

                <div class="form-container">
                    <form method="POST" action="rekrutacja_form.php">
                        <h3>Dane Dziecka</h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="imie" class="required">Imię</label>
                                <input type="text" id="imie" name="imie" required>
                            </div>
                            <div class="form-group">
                                <label for="nazwisko" class="required">Nazwisko</label>
                                <input type="text" id="nazwisko" name="nazwisko" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="pesel" class="required">PESEL</label>
                                <input type="text" id="pesel" name="pesel" placeholder="np. 12345678901" maxlength="11" required>
                            </div>
                        </div>

                        <h3>Dane Matki</h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="imie_mamy">Imię</label>
                                <input type="text" id="imie_mamy" name="imie_mamy">
                            </div>
                            <div class="form-group">
                                <label for="nazwisko_mamy">Nazwisko</label>
                                <input type="text" id="nazwisko_mamy" name="nazwisko_mamy">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="nr_telefonu_mamy">Numer telefonu</label>
                                <input type="tel" id="nr_telefonu_mamy" name="nr_telefonu_mamy">
                            </div>
                            <div class="form-group">
                                <label for="email_mamy">Adres e-mail</label>
                                <input type="email" id="email_mamy" name="email_mamy">
                            </div>
                        </div>

                        <h3>Dane Ojca</h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="imie_taty">Imię</label>
                                <input type="text" id="imie_taty" name="imie_taty">
                            </div>
                            <div class="form-group">
                                <label for="nazwisko_taty">Nazwisko</label>
                                <input type="text" id="nazwisko_taty" name="nazwisko_taty">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="nr_telefonu_taty">Numer telefonu</label>
                                <input type="tel" id="nr_telefonu_taty" name="nr_telefonu_taty">
                            </div>
                            <div class="form-group">
                                <label for="email_taty">Adres e-mail</label>
                                <input type="email" id="email_taty" name="email_taty">
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="submit-btn">Wyślij Zgłoszenie</button>
                        </div>
                    </form>
                </div>
            </article>
        </main>
        <footer>
            <table>
                <tr><th>Adres</th><th>Kontakt</th><th>Mapa</th></tr>
                <tr>
                    <td>ul. Wesoła 12</td>
                    <td>E-mail: <a href="mailto:kontakt@maleskrzaty.pl">kontakt@maleskrzaty.pl</a></td>
                    <td rowspan="2">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d733.6564960265912!2d19.482710198832795!3d51.79308105045472!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x471bcb1cb30d33df%3A0x3bddd46b3ba43f17!2sPrzedszkole%20nr%209%20Miejskie!5e0!3m2!1spl!2spl!4v1762619710896!5m2!1spl!2spl" width="150" height="112" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </td>
                </tr>
                <tr>
                    <td>93-152 Łódź</td>
                    <td>Tel.: <a href="tel:426784532">42 678 45 32</a></td>
                </tr>
            </table>
        </footer>
    </div>
</body>
</html>
