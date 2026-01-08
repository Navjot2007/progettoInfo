<?php
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

    /* ================== INSERIMENTO EVENTO ================== */
    if (isset($_POST['azione'])) {

        if (
            empty($_POST['titolo']) ||
            empty($_POST['luogo']) ||
            empty($_POST['data'])
        ) {
            echo "<p>Inserisci i dati correttamente!</p>";
        }

        $titolo = $_POST['titolo'];
        $luogo = $_POST['luogo'];
        $data = $_POST['data'];
        $nickname = 'user_A';

        $stmt = $pdo->prepare("
            INSERT INTO evento (titolo, luogo, `data`, nickname)
            VALUES (:titolo, :luogo, :data, :nickname)
        ");
        $stmt->bindParam(':titolo',$titolo);
        $stmt->bindParam(':luogo',$luogo);
        $stmt->bindParam(':data',$data);
        $stmt->bindParam(':nickname',$nickname);

        $stmt->execute();

        header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
        exit();

        if (!isset($titolo)) $titolo = "";
        if (!isset($luogo)) $luogo = "";
        if (!isset($data)) $data = "";
    }


    echo "Evento:<br>";
    $stmt = $pdo->query("SELECT * FROM evento");
    echo "<table border='1'>";
    foreach ($stmt as $row) {
        echo "<tr>";
        echo "<td>{$row['idEvento']}</td>";
        echo "<td>{$row['titolo']}</td>";
        echo "<td>{$row['luogo']}</td>";
        echo "<td>{$row['data']}</td>";
        echo "<td>{$row['nickname']}</td>";
        echo "</tr>";
    }
    echo "</table><br>";

    echo "Categoria:<br>";
    $stmt = $pdo->query("SELECT * FROM categoria");
    echo "<table border='1'>";
    foreach ($stmt as $row) {
        echo "<tr>";
        echo "<td>{$row['idCategoria']}</td>";
        echo "<td>{$row['nome']}</td>";
        echo "</tr>";
    }
    echo "</table><br>";

    echo "Artista:<br>";
    $stmt = $pdo->query("SELECT * FROM artista");
    echo "<table border='1'>";
    foreach ($stmt as $row) {
        echo "<tr>";
        echo "<td>{$row['idArtista']}</td>";
        echo "<td>{$row['nome']}</td>";
        echo "</tr>";
    }
    echo "</table><br>";

    echo "Post:<br>";
    $stmt = $pdo->query("SELECT * FROM post");
    echo "<table border='1'>";
    foreach ($stmt as $row) {
        echo "<tr>";
        echo "<td>{$row['idPost']}</td>";
        echo "<td>{$row['commento']}</td>";
        echo "</tr>";
    }
    echo "</table><br>";

    echo "Utente:<br>";
    $stmt = $pdo->query("SELECT * FROM utente");
    echo "<table border='1'>";
    foreach ($stmt as $row) {
        echo "<tr>";
        echo "<td>{$row['nickname']}</td>";
        echo "<td>{$row['nome']}</td>";
        echo "</tr>";
    }
    echo "</table><br>";

} catch (PDOException $e) {
    echo "Errore DB: " . $e->getMessage();
}

$pdo = null;
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Inserisci Evento</title>
</head>
<body>

<h2>Inserisci nuovo evento</h2>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <table>
        <tr>
            <td>Titolo:</td>
            <td><input type="text" name="titolo"></td>
        </tr>
        <tr>
            <td>Luogo:</td>
            <td><input type="text" name="luogo"></td>
        </tr>
        <tr>
            <td>Data:</td>
            <td><input type="date" name="data"></td>
        </tr>
    </table>

    <button type="submit" name="azione">Inserisci</button>
</form>

</body>
</html>
