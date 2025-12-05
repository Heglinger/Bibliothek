<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anmelden</title>
</head>
<body>
<h1>Anmelden</h1>

<form action="verwaltung.php" method="post">
<input type="text" id="benutzername" name="benutzername" placeholder="Benutzername" required>
<br>
<input type="password" id="passwort" name="passwort" placeholder="Passwort" required>
<br>
<input type="submit" value="Anmelden" name="anmelden">
</form>
<?php
if(isset($_POST["anmelden"])){
$benutzername = $_POST["benutzername"];
$passwort = $_POST["passwort"];
$verbindung = mysqli_connect("localhost","root","","buecherei")
or die(mysqli_connect_error());
$sql = "SELECT * FROM t_bibliothekare WHERE benutzername = '$benutzername' AND passwort = '$passwort'";
$ergebnis = mysqli_query($verbindung, $sql);
if(mysqli_num_rows($ergebnis) != 0){
    header("Location: verwaltung.php");
} else {
    echo "Falscher Benutzername oder Passwort.";
}
mysqli_close($verbindung);
}
?>
</body>
</html>