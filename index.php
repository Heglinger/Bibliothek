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
<input type="submit" name="aendern">
</form>
<table id="aendern">
<?php
if(isset($_POST["aendern"])){
$verbindung = mysqli_connect("localhost","root","","Buecherei")
or die("Verbindungsfehler" . mysqli_connect_error());

$sql = "SELECT * FROM t_buecher";
$ergebnis = mysqli_query($verbindung, $sql);
while($row = mysqli_fetch_array($ergebnis)){
    echo "<tr><td>".$row['buchnr']."</td>";
    echo "<td>".$row['titel']."</td>";
    echo "<td>".$row['autor']."</td>";
    echo "<td>".$row['beschreibung']."</td></tr><br>";
}
}
?>
</table>
</body>
</html>