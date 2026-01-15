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
    if(($_SESSION['tentativi']<5)) {
        if (isset($_POST['accedi'])) {

            if (
                    empty($_POST['nickname']) ||
                    empty($_POST['password'])
            ) {
                echo "<p>Completa tutti i campi!</p>";
            }

            $nickname = $_POST['nickname'];
            $psw = $_POST['password'];

            $stmt = $pdo->query("SELECT nickname, password FROM utente");
            foreach ($stmt as $row) {
                if ($row['nickname'] === $nickname && $row['password'] === $psw) {


                    $_SESSION['nickname'] = $nickname;
                    $_SESSION['password'] = $psw;
                    $autenticazione = true;
                    echo "<p>Utente trovato</p>";

                }
            }
            if (!$autenticazione) {
                $_SESSION['tentativi']++;
                echo "<p>Utente non trovato</p>";
            }

            if ($autenticazione) {
                echo "<a href='aggiungiEvento.php'><button> Aggiungi evento</button></a>";
            }

        }
    }else {
        echo("Hai raggiunto i tentativi massimi, aspetta prima di risprovare");
        if (!isset($_SESSION['start'])) {
            $_SESSION['start'] = time();
        }
        if (isset($_SESSION['start']) && (time() - $_SESSION['start'] > 15)) {
            session_unset();
            session_destroy();
        }
    }


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
            <td><input type="text" name="password"></td>
        </tr>

    </table>

    <button type="submit" name="accedi">Accedi</button>
</form>

</body>
</html>