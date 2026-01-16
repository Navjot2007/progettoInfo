<?php
session_start();
if (!isset($_SESSION['nickname'])) {
    header("Location: access.php");
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

        if (empty($_POST['idEvento']))
        {
            echo "<p>Seleziona un evento!</p>";
        }

        $idEvento = $_POST['idEvento'];
        echo "Commento:<br>";
        $stmt = $pdo->query("SELECT * FROM post,evento WHERE post.idEvento = evento.idEvento AND evento.idEvento =".$idEvento." ");

        if($stmt->rowCount() > 0) {
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
        }
        else {
            echo "<p>Nessun commento collegato a questo evento!</p>";
        }
        if (!isset($idEvento)) $idEvento = "";

    }


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

    echo "<a href='giudizio.php'><button>Aggiungi commento</button></a>";
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
    <title>Visualizza commenti</title>
</head>
<body>

<h2>Visualizza commenti</h2>

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
    </table>

    <button type="submit" name="azione">Visualizza</button>
</form>

</body>
</html>
