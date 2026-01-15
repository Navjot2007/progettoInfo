<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <table>
        <tr>
            <td>Password</td>
            <td>
                <iput  type="text" name="utente"
                <input type="text" name="psw" >
                <button type="submit" name="registrazione" value="registrazione">Registrazione</button>


                "
            </td>
            <td></td>
        </tr>
    </table>
</form>
<?php
$host = 'localhost';
$db   = 'community';
$user = 'community';
$pass = 'community';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Abilita eccezioni
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Risultati come array associativi
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Preparazione vera
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
session_start();
$_SESSION['j'] = 1;
if (isset($_POST['registrazione']) && $_POST['registrazione'] == 'registrazione') {
    $utente = $_POST['utente']; // Usa ?? '' per default se non inviato
    $psw = $_POST['psw'];
    if (!empty($utente) &&!empty($psw)){
        $sql = "INSERT INTO utenti (utente, psw) VALUES (?, ?)";



        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$utente, $psw]); // Esegui con i valori passati
            echo "Dati inseriti con successo!";
        } catch (\PDOException $e) {
            echo "Errore nell'inserimento: " . $e->getMessage();
        }
    }
    else echo "babbo metti i dati";


}