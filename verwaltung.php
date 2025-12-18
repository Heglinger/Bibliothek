<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
    <style>
        #aendern td, tr {
            border: 1px solid black;
        }
        #aendern {
            border-collapse: collapse;
        }
        
    </style>
</head>
<body>
    <h2>Bücher einschreiben</h2>
<?php
if(!isset($_SESSION['angemeldet']) || $_SESSION['angemeldet'] == false){
    echo "Sie sind nicht angemeldet. <a href='anmeldung.php'>Hier</a> anmelden.";
}
$verbindung = mysqli_connect("localhost","root","","Buecherei")
or die("Verbindungsfehler" . mysqli_connect_error());
?>
<!-- Formular zum Einschreiben von Büchern -->
    <form action="verwaltung.php" method="post">
    <input type="text" id="titelid" name="titel" placeholder="Titel" required>
    <br>
    <input type="text" id="autor" name= "autor" placeholder="Autor">
    <br>
    <textarea name="beschreibung" id="beschreibung" placeholder="Beschreibung Max 100 Zeichen" required></textarea>
    <br>
    <input type="submit" name="eingabebutton" value="Eingabe">
</form>
<?php
// Einfügen der Bücher in die Datenbank
if(isset($_POST["eingabebutton"])&& $_SESSION['angemeldet'] == true){
    $titel = $_POST["titel"];
    $autor = $_POST["autor"];
    $beschreibung = $_POST["beschreibung"];
    $sql = "INSERT INTO t_buecher (autor, titel, beschreibung) VALUES ('$autor', '$titel', '$beschreibung')";
    mysqli_query($verbindung, $sql);
    mysqli_close($verbindung);
}

?>

<h2>Bücher verwalten</h2>
<form action="" method="post">
<input type="submit" name="aendern" value="Anzeigen">
</form>
<table id="aendern">
<?php
// Anzeigen der Bücher + Möglichkeit zum Ändern und Löschen
if(isset($_POST["aendern"])&& $_SESSION['angemeldet'] == true){
$verbindung = mysqli_connect("localhost","root","","Buecherei")
or die("Verbindungsfehler" . mysqli_connect_error());

$sql = "SELECT * FROM t_buecher";
$ergebnis = mysqli_query($verbindung, $sql);
while($row = mysqli_fetch_array($ergebnis)){
    echo "<form action='' method='post'>";
        
    echo "<td><input type='hidden' name='buchnr' value='".$row['buchnr']."'></td>";
    echo "<td><input type='text' id='titelid' name='titel2' value='".$row['titel']."'></td>";
    echo "<td><input type='text' id='autor' name='autor2' value='".$row['autor']."'></td>";
    echo "<td><textarea name='beschreibung2' id='beschreibung' placeholder='Beschreibung'>".$row['beschreibung']."</textarea></td>";
    echo "<td><input type='text' id='ausgeliehen' name='ausgeliehen2' placeholder ='Ausgeliehen an' value='".$row['ausgeliehen']."'></td>";
    echo "<td><input type='submit' name='aendernbutton' value='Ändern'></td>";
    echo "<td><input type='submit' name='loeschenbutton' value='Löschen'></td>";
    echo "</form></tr>";
}
    mysqli_close($verbindung);
}
//Ändern
if (isset($_POST["aendernbutton"])) {
    $verbindung = mysqli_connect("localhost","root","","Buecherei") or die(mysqli_connect_error());
    $buchnr = intval($_POST['buchnr']); 
    $titel = $_POST["titel2"];
    $autor = $_POST["autor2"];
    $beschreibung = $_POST["beschreibung2"];
    $ausgeliehen = $_POST["ausgeliehen2"];

    // Prepared Statement nutzen
    $stmt = mysqli_prepare($verbindung, "UPDATE t_buecher SET autor = ?, titel = ?, beschreibung = ?, ausgeliehen = ? WHERE buchnr = ?");
    mysqli_stmt_bind_param($stmt, "ssssi", $autor, $titel, $beschreibung, $ausgeliehen, $buchnr);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($verbindung);

    header("Location: verwaltung.php");
    exit;
}
//Löschen
if (isset($_POST["loeschenbutton"])) {
    $verbindung = mysqli_connect("localhost","root","","Buecherei") or die(mysqli_connect_error());
    $buchnr = intval($_POST['buchnr']); 

    // Prepared Statement nutzen
    $stmt = mysqli_prepare($verbindung, "DELETE FROM t_buecher WHERE buchnr = ?");
    mysqli_stmt_bind_param($stmt, "i", $buchnr);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($verbindung);

    header("Location: verwaltung.php");
    exit;
}
?>
</form>
</table>
<p></p>

<!-- Abmelden -->
<form action="verwaltung.php" method="post">
<input type="submit" name="abmelden" value="abmelden">
<?php
if (isset($_POST["abmelden"])) {
    session_destroy();
    header("Location: anmeldung.php");
    exit;
}
?>
</body>
</html>