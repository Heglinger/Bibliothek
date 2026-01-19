<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>index</title>
    <style>
 /* Grundlayout */
body {
    font-family: Arial, Helvetica, sans-serif;
    background-color: #eef1f5;
    color: #2f2f2f;
    margin: 0;
    padding: 24px;
}

/* Überschriften */
h1, h2 {
    color: #2c5d8a;
    margin-bottom: 12px;
}

/* Formulare */
form {
    background-color: #ffffff;
    padding: 16px;
    margin-bottom: 24px;
    border-radius: 8px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.08);
    max-width: 750px;
}

/* Einheitliche Eingabefelder */
input[type="text"],
input[type="password"],
input[type="date"],
textarea,
select {
    width: 100%;
    padding: 9px;
    margin: 6px 0 14px 0;
    border: 1px solid #cfd6df;
    border-radius: 6px;
    font-size: 14px;
    font-family: inherit;
    color: #333;
    background-color: #f9fafb;
    transition: border-color 0.2s, box-shadow 0.2s;
}

input:focus,
textarea:focus,
select:focus {
    border-color: #3a78b5;
    box-shadow: 0 0 0 2px rgba(58,120,181,0.15);
    outline: none;
}

textarea {
    resize: vertical;
}


/* Buttons allgemein */
input[type="submit"] {
    background-color: #3a78b5;
    color: #ffffff;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.2s, transform 0.1s;
}

input[type="submit"]:hover {
    background-color: #2c5d8a;
    transform: translateY(-1px);
}

/* Löschen-Button */
input[name="loeschenbutton"] {
    background-color: #c0392b;
}

input[name="loeschenbutton"]:hover {
    background-color: #a93226;
}

/* Tabelle */
#aendern {
    width: 100%;
    border-collapse: collapse;
    background-color: #ffffff;
    box-shadow: 0 3px 8px rgba(0,0,0,0.08);
    border-radius: 8px;
    overflow: hidden;
}

#aendern td,
#aendern th {
    border: 1px solid #e0e6ed;
    padding: 8px;
    font-size: 14px;
}

#aendern tr:nth-child(even) {
    background-color: #f5f7fa;
}

/* Links */
a {
    color: #3a78b5;
    text-decoration: none;
    font-weight: 500;
}

a:hover {
    text-decoration: underline;
}

    </style>
</head>
<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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
    <input type="text" id="genre" name="genre" placeholder="Genre">
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
    $genre = $_POST["genre"];
    $beschreibung = $_POST["beschreibung"];
    $sql = "INSERT INTO t_buecher (autor, titel, genre, beschreibung) VALUES ('$autor', '$titel', '$genre', '$beschreibung')";
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
    echo "<td><input type='text' id='genre' name='genre2' value='".$row['genre']."'></td>";
    echo "<td><textarea name='beschreibung2' id='beschreibung' placeholder='Beschreibung'>".$row['beschreibung']."</textarea></td>";
    echo "<td><input type='text' id='ausgeliehen' name='ausgeliehen2' placeholder ='Ausgeliehen an:' value='".$row['ausgeliehen']."'></td>";
    echo "<td><input type='text' name='ausleihdatum' placeholder='Ausleihdatum' value='".$row['ausleihdatum']."'></td>";
    echo "<td><input type='submit' name='aendernbutton' value='Ändern'></td>";
    echo "<td><input type='submit' name='loeschenbutton' value='Löschen'></td>";
    echo "</form>";
    echo "</tr>";
}

    mysqli_close($verbindung);
}
//Ändern
if (isset($_POST["aendernbutton"])) {
    $verbindung = mysqli_connect("localhost","root","","Buecherei") or die(mysqli_connect_error());
    $buchnr = intval($_POST['buchnr']); 
    $titel = $_POST["titel2"];
    $autor = $_POST["autor2"];
    $genre = $_POST["genre2"];
    $beschreibung = $_POST["beschreibung2"];
    $ausgeliehen = $_POST["ausgeliehen2"];
    $ausleihdatum = $_POST["ausleihdatum"];

    // Prepared Statement nutzen
    $stmt = mysqli_prepare($verbindung, "UPDATE t_buecher SET autor = ?, titel = ?, genre = ?, beschreibung = ?, ausgeliehen = ?, ausleihdatum = ? WHERE buchnr = ?");
    mysqli_stmt_bind_param($stmt, "ssssssi", $autor, $titel, $genre, $beschreibung, $ausgeliehen, $ausleihdatum, $buchnr);
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
<br>
<a href="index.php">Zur Startseite</a>
</body>
</html>