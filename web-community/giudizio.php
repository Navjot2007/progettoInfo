<?php
session_start();
if (!isset($_SESSION['nickname'])) {
    header("Location: accesso.php");
    exit();
}
$host = '127.0.0.1';
$db   = 'community';
$user = 'community';
$pass = 'community';
$charset = 'utf8mb4';

try {
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $options);

    /* ================== INSERIMENTO GIUDIZIO ================== */
    if (isset($_POST['azione'])) {

        if (
            empty($_POST['commento']) ||
            empty($_POST['voto']) || empty($_POST['idEvento']) || is_numeric($_POST['voto'])
        ) {
            echo "<p>Inserisci i dati correttamente!</p>";
        }

        $idEvento = $_POST['idEvento'];
        $voto = $_POST['voto'];
        $commento = $_POST['commento'];
        $nickname = $_SESSION['nickname'];

        $stmt = $pdo->prepare("
            INSERT INTO post (commento, voto, idEvento, nickname)
            VALUES (:commento, :voto, :idEvento, :nickname)
        ");
        $stmt->bindParam(':commento',$commento);
        $stmt->bindParam(':voto',$voto);
        $stmt->bindParam(':idEvento',$idEvento);
        $stmt->bindParam(':nickname',$nickname);

        $stmt->execute();

        header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
        exit();

        if (!isset($commento)) $commento = "";
        if (!isset($voto)) $voto = "";
        if (!isset($idEvento)) $idEvento = "";
    }

    echo "Commento:<br>";
    $stmt = $pdo->query("SELECT * FROM post");
    echo "<table border='1'>";
    foreach ($stmt as $row) {
        echo "<tr>";
        echo "<td>{$row['idPost']}</td>";
        echo "<td>{$row['commento']}</td>";
        echo "<td>{$row['voto']}</td>";
        echo "<td>{$row['idEvento']}</td>";
        echo "<td>{$row['nickname']}</td>";
        echo "</tr>";
    }
    echo "</table>";

    echo "Evento:<br>";
    $stmt = $pdo->query("SELECT * FROM evento");
    echo "<table border='1'>";
    foreach ($stmt as $row) {
        echo "<tr>";
        echo "<td>{$row['idEvento']}</td>";
        echo "<td>{$row['luogo']}</td>";
        echo "<td>{$row['data']}</td>";
        echo "<td>{$row['titolo']}</td>";
        echo "<td>{$row['nickname']}</td>";
        echo "</tr>";
    }
    echo "</table>";

    echo "<a href='visualizzaCommenti.php'><button>Visualizza commenti</button></a>";
    echo "<a href='aggiungiEvento.php'><button>Aggiungi evento</button></a>";
    echo "<a href='disconnetti.php'><button>Disconnetti</button></a>";

} catch (PDOException $e) {
    echo "Errore DB: " . $e->getMessage();
}

$pdo = null;
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Inserisci Commento</title>
</head>
<body>

<h2>Inserisci nuovo commento</h2>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <table>
        <tr>
            <td>ID evento:</td>
            <td>
            <?php
            $pdo = new PDO($dsn, $user, $pass, $options);

            $stmt = $pdo->query("SELECT * FROM evento");
            foreach ($stmt as $row){
                $evento = $row['idEvento'];
                echo "<input type='radio' id=$evento name='idEvento' value=$evento>$evento";
            }

            $pdo = null;
            ?>
            </td>
        </tr>
        <tr>
            <td>Commento:</td>
            <td><input type="text" name="commento"></td>
        </tr>
        <tr>
            <td>Voto:</td>
            <td><input type="text" name="voto"></td>
        </tr>
    </table>

    <button type="submit" name="azione">Inserisci</button>
</form>

</body>
</html>
