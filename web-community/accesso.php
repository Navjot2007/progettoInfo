<?php

$host = '127.0.0.1';
$db   = 'community';
$user = 'community';
$pass = 'community';
$charset = 'utf8mb4';

session_start();

try {
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $options);

    $autenticazione = false;

    if (!isset($_SESSION['tentativi'])) {
        $_SESSION['tentativi'] = 0;
    }

    if ($_SESSION['tentativi'] < 2) {

        if (isset($_POST['accedi'])) {

            if (empty($_POST['nickname']) || empty($_POST['password'])) {
                echo "<p>Completa tutti i campi!</p>";
                exit();
            }

            $nickname = $_POST['nickname'];
            $psw = $_POST['password'];

            $stmt = $pdo->query("SELECT nickname, password FROM utente");

            foreach ($stmt as $row) {
                if ($row['nickname'] === $nickname && $row['password'] === $psw && $autenticazione === false) {

                    $_SESSION['nickname'] = $nickname;
                    $autenticazione = true;

                    echo "<p>Utente trovato</p>";
                }
            }

            if (!$autenticazione) {
                $_SESSION['tentativi']++;

                $tentativo = max(0, 3 - $_SESSION['tentativi']);

                echo "<p>Utente non trovato</p>";
                echo "<p>Tentativi rimanenti: $tentativo</p>";
            }

            if ($autenticazione) {
                echo "<a href='aggiungiEvento.php'><button>Aggiungi evento</button></a>";
            }

        }

    } else {

        $tempoAttesa = 12;

        if (!isset($_SESSION['start'])) {
            $_SESSION['start'] = time();
        }

        $sblocco = $_SESSION['start'] + $tempoAttesa;

        if (time() < $sblocco) {
            $orario = date("H:i:s", $sblocco);

            echo "<p>Hai raggiunto i tentativi massimi.</p>";
            echo "<p>Potrai riprovare alle <strong>$orario</strong>.</p>";
        } else {
            session_unset();
            session_destroy();
            echo "<p>Ora puoi riprovare.</p>";
        }
    }

    if(isset($nickname))

} catch (PDOException $e) {
    echo "Errore DB: " . $e->getMessage();
}

$pdo = null;
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Accesso</title>
</head>
<body>

<h2>Accesso</h2>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <table>
        <tr>
            <td>Nickname:</td>
            <td><input type="text" name="nickname"></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="password"></td>
        </tr>
    </table>

    <button type="submit" name="accedi">Accedi</button>
</form>

</body>
</html>
