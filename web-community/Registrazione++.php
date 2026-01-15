<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <table>
        <tr>
            <td>Nickname
                <input  type="text" name="utente"></td>
        <tr></tr>
            <td>Nome
                <input  type="text" name="nome"></td>
        <tr></tr>
            <td>Cognome
                <input  type="text" name="cognome"></td>
        <tr></tr>


        <td>Email
            <input  type="text" name="email"></td>
        <tr></tr>
            <td>Provincia
                <input  type="text" name="provincia"></td>
            <tr></tr>
            <td>Password
                <input type="text" name="psw" ></td>
        <tr></tr>

            <td><button type="submit" name="registrazione" value="registrazione">Registrazione</button></td>
        </tr>
    </table>
</form>
<?php
// Dettagli connessione (da adattare)
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
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}
function contiamo($password)
{
    for ($i = 0; $i < strlen($password); $i++) {
        if ($password[$i] >= '0' && $password[$i] <= '9') {
            return false;
        }
    }
    return true;
}
function primaMaiuscola($password)
{
    for($i = 0; $i < strlen($password); $i++) {
        if ($password[$i] >= 'A' && $password[$i] <= 'Z')
            return false;
    }
    return true;
}
function metaCaratteri($password)
{
    for ($i = 0; $i < strlen($password); $i++) {
        if ($password[$i] >= '!' && $password[$i] <= '/'|| $password[$i] >= ':' && $password[$i] <= '@') {
            return false;
        }
    }
    return true;
}
function lunghezza($password)
{
    if (strlen($password) <= 7)
        return true;
    return false;
}
$_SESSION['j'] = 1;
if (isset($_POST['registrazione']) && $_POST['registrazione'] == 'registrazione') {
    $utente = $_POST['utente'];
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $email = $_POST['email'];
    $provincia = $_POST['provincia'];
    $password = $_POST['psw'];
    if (lunghezza($password)) {
        die("La password deve essere più lunga di 7");
    }
    if (contiamo($password)) {
        die("Non ci sono abbastanza numeri nella password");
    }
    if (primaMaiuscola($password)) {
        die("Non ci sono maiuscole nella password");
    }
    if (metaCaratteri($password)) {
        echo("Deve esserci almeno un metacarattere nella password");
    }
if (!empty($utente) &&!empty($password)&&!empty($provincia)&&!empty($nome)&&!empty($cognome)&&!empty($email)){
    $sql = "INSERT INTO utente (nickname, nome, cognome, email, provincia, password ) VALUES (?,?,?,?,?,?)";
}
else echo "babbo metti i dati";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$utente, $nome, $cognome, $email, $provincia, $password]);
        echo "Dati inseriti con successo!";
    } catch (\PDOException $e) {
        echo "Errore nell'inserimento: " . $e->getMessage();
    }
}

else {echo "errore datlabase";


}
?>
