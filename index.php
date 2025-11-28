<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
</head>
<body>
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
</body>
</html>