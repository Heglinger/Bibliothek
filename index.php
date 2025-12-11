<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Startseite</title>
    <style>
        #suchergebnis td, th {
            border: 1px solid black;
        }
        #suchergebnis {
            border-collapse: collapse;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Schulbibliothek</h1>
    <h3>Bücher suchen🔎</h3>
    <form action="index.php" method="post">
        <input type="text" name="suchbegriff" placeholder="Buch eingeben">
        <input type="submit" value="Suchen" name="suchen">
    </form>
    <?php 
    if(isset($_POST["suchen"])){
    $suchbegriff = $_POST["suchbegriff"];
    $verbindung = mysqli_connect("localhost","root","","Buecherei")
    or die(mysqli_connect_error());
    $sql = "SELECT * FROM t_buecher WHERE titel LIKE '$suchbegriff%';";
    $result = mysqli_query($verbindung,$sql);
        echo "<table id='suchergebnis'>";
        echo "<th>Buchnr</th>";
        echo "<th>Titel</th>";
        echo "<th>Beschreibung</th>";
        echo "<th>Autor</th>";
    while($row = mysqli_fetch_array($result)){
        echo "<tr><td>".$row['buchnr']."</td>";
        echo "<td>".$row['titel']."</td>";
        echo "<td>".$row['beschreibung']."</td>";
        echo "<td>".$row['autor']."</td></tr><br>";   
    }
    echo "</table>"; 
    }
    ?>
    <h3>Für Bibliothekare</h3>
    <a href="anmeldung.php">Zum Anmelden</a>
</body>
</html>