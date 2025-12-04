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
$verbindung = mysqli_connect("localhost","root","","Buecherei")
or die("Verbindungsfehler" . mysqli_connect_error());
?>
    <form action="index.php" method="post">
    <input type="text" id="titelid" name="titel" placeholder="Titel">
    <br>
    <input type="text" id="autor" name= "autor" placeholder="Autor">
    <br>
    <textarea name="beschreibung" id="beschreibung" placeholder="Beschreibung"></textarea>
    <br>
    <input type="submit" name="eingabebutton" value="Eingabe">
</form>
<?php
if(isset($_POST["eingabebutton"])){
    $titel = $_POST["titel"];
    $autor = $_POST["autor"];
    $beschreibung = $_POST["beschreibung"];
    $sql = "INSERT INTO t_buecher (autor, titel, beschreibung) VALUES ('$autor', '$titel', '$beschreibung')";
    mysqli_query($verbindung, $sql);
    mysqli_close($verbindung);
}

?>

<h2>Bücher ändern</h2>
<form action="" method="post">
<input type="submit" name="aendern" value="Anzeigen">
</form>
<table id="aendern">
<?php
if(isset($_POST["aendern"])){
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
    echo "<td><input type='submit' name='aendernbutton' value='Ändern'></td>";
    echo "</form></tr>";

}
    mysqli_close($verbindung);
}
if (isset($_POST["aendernbutton"])) {
    $verbindung = mysqli_connect("localhost","root","","Buecherei") or die(mysqli_connect_error());
    $buchnr = intval($_POST['buchnr']); // sicherheit: int cast
    $titel = $_POST["titel2"];
    $autor = $_POST["autor2"];
    $beschreibung = $_POST["beschreibung2"];

    // Prepared Statement nutzen
    $stmt = mysqli_prepare($verbindung, "UPDATE t_buecher SET autor = ?, titel = ?, beschreibung = ? WHERE buchnr = ?");
    mysqli_stmt_bind_param($stmt, "sssi", $autor, $titel, $beschreibung, $buchnr);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($verbindung);

    // Redirect, damit die Seite neu geladen wird (PRG)
    header("Location: index.php");
    exit;
}
?>
</table>
</body>
</html>