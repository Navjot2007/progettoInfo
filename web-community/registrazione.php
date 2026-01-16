<?php
session_start();

// 1. Inizializziamo le variabili dei campi come vuote
$dati = [
        'utente' => '',
        'nome' => '',
        'cognome' => '',
        'email' => '',
        'provincia' => '',
];

// 2. Se il form è stato inviato (POST), popoliamo $dati con quello che ha scritto l'utente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrazione'])) {
    $dati['utente'] = $_POST['utente'];
    $dati['nome'] = $_POST['nome'];
    $dati['cognome'] = $_POST['cognome'];
    $dati['email'] = $_POST['email'];
    $dati['provincia'] = $_POST['provincia'];
}
// Se non è un POST (quindi è un caricamento pulito della pagina),
// $dati rimarrà vuoto come definito sopra.

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <title>Registrazione</title>
</head>
<body>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <table>
        <tr>
            <td>Nickname</td>
            <td><input type="text" name="utente" value="<?php echo htmlspecialchars($dati['utente']); ?>"></td>
        </tr>
        <tr>
            <td>Nome</td>
            <td><input type="text" name="nome" value="<?php echo htmlspecialchars($dati['nome']); ?>"></td>
        </tr>
        <tr>
            <td>Cognome</td>
            <td><input type="text" name="cognome" value="<?php echo htmlspecialchars($dati['cognome']); ?>"></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="text" name="email" value="<?php echo htmlspecialchars($dati['email']); ?>"></td>
        </tr>
        <tr>
            <td>Provincia</td>
            <td><input type="text" name="provincia" value="<?php echo htmlspecialchars($dati['provincia']); ?>"></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" name="psw"></td> </tr>
        <tr>
            <td><button type="submit" name="registrazione" value="registrazione">Registrazione</button></td>
        </tr>
    </table>
</form>

<?php
// Connessione al database
$host = '127.0.0.1';
$db   = 'community';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Errore connessione: " . $e->getMessage());
}

function contiamo($password) {
    for ($i = 0; $i < strlen($password); $i++) {
        if ($password[$i] >= '0' && $password[$i] <= '9') return false;
    }
    return true;
}
function primaMaiuscola($password) {
    for($i = 0; $i < strlen($password); $i++) {
        if ($password[$i] >= 'A' && $password[$i] <= 'Z') return false;
    }
    return true;
}
function metaCaratteri($password) {
    for ($i = 0; $i < strlen($password); $i++) {
        if (($password[$i] >= '!' && $password[$i] <= '/') || ($password[$i] >= ':' && $password[$i] <= '@')) return false;
    }
    return true;
}
function lunghezza($password) {
    return strlen($password) <= 7;
}

// Logica di validazione
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrazione'])) {

    $password = $_POST['psw'];
    $errore_password = false;

    // Controlli password
    if (lunghezza($password)) {
        echo "La password deve essere più lunga di 7 caratteri."; $errore_password = true; }
    if (contiamo($password)) {
        echo "Inserisci almeno un numero nella password."; $errore_password = true; }
    if (primaMaiuscola($password)) {
        echo "Inserisci almeno una maiuscola."; $errore_password = true; }
    if (metaCaratteri($password)) {
        echo "Inserisci almeno un carattere speciale."; $errore_password = true; }

    if (!$errore_password) {
        // Se la password è OK, procediamo con il resto
        if (empty($dati['utente']) || empty($dati['nome']) || empty($dati['cognome']) || empty($dati['email']) || empty($password)) {
            echo "Tutti i campi sono obbligatori.
";
        } else {
            try {
                $sql = "INSERT INTO utente (nickname, nome, cognome, email, provincia, password) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                // NOTA: In produzione usa password_hash($password, PASSWORD_DEFAULT)
                $stmt->execute([$dati['utente'], $dati['nome'], $dati['cognome'], $dati['email'], $dati['provincia'], $password]);

                echo "<strong>Registrazione completata!</strong>
";
                echo "<a href='accesso.php'><button>Vai al login</button></a>";

                // In caso di successo, svuotiamo l'array $dati così il form torna vuoto
                $dati = array_fill_keys(array_keys($dati), '');

            } catch (PDOException $e) {
                echo "Errore database: " . $e->getMessage();
            }
        }
    }
}
?>
</body>
</html>
