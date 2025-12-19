<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anmelden</title>
</head>
<body>
<h1>Anmelden</h1>

<form action="anmeldung.php" method="post">
<input type="text" id="benutzername" name="benutzername" placeholder="Benutzername" required>
<br>
<input type="password" id="passwort" name="passwort" placeholder="Passwort" required>
<br>
<input type="submit" value="Anmelden" name="anmelden">
</form>
<?php
$_SESSION["angemeldet"] = false;
if(isset($_POST["anmelden"])){
$benutzername = $_POST["benutzername"];
$passwort = $_POST["passwort"];
$verbindung = mysqli_connect("localhost","root","","buecherei")
or die(mysqli_connect_error());
$sql = "SELECT * FROM t_bibliothekar WHERE benutzername = ? AND passwort = ?";
$stmt = mysqli_prepare($verbindung, $sql);
mysqli_stmt_bind_param($stmt, "ss", $benutzername, $passwort);
mysqli_stmt_execute($stmt);
$ergebnis = mysqli_stmt_get_result($stmt);
if(mysqli_num_rows($ergebnis) != 0){
    $_SESSION["angemeldet"] = true;
    header("Location: verwaltung.php");
} else {
    echo "Falscher Benutzername oder Passwort.";
    $_SESSION["angemeldet"] = false;
}
mysqli_close($verbindung);
}
?>

<a href="index.php">Zur Startseite</a>

</body>
</html>