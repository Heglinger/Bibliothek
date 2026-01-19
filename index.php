<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Startseite</title>
    <style>
body {
    font-family: Arial, Helvetica, sans-serif;
    background-color: #f2f4f7;
    color: #333;
    padding: 20px;
}

h1 {
    color: #2c5d8a;
}

h3 {
    color: #3a78b5;
}

form {
    background-color: #ffffff;
    padding: 15px;
    border-radius: 6px;
    max-width: 500px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

input[type="text"],
select {
    width: 100%;
    padding: 8px;
    margin-top: 6px;
    margin-bottom: 12px;
    border-radius: 4px;
    border: 1px solid #ccc;
}

input[type="submit"] {
    background-color: #3a78b5;
    color: white;
    border: none;
    padding: 8px 14px;
    border-radius: 4px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #2c5d8a;
}

#suchergebnis {
    border-collapse: collapse;
    margin-top: 20px;
    width: 100%;
    background-color: white;
}

#suchergebnis td,
#suchergebnis th {
    border: 1px solid #ccc;
    padding: 8px;
}

#suchergebnis th {
    background-color: #e3ebf5;
}

#suchergebnis tr:nth-child(even) {
    background-color: #f7f9fc;
}

a {
    color: #3a78b5;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

    </style>
</head>
<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<body>
    <h1>Schulbibliothek</h1>
    <h3>Bücher suchen🔎</h3>

    <!--Suchformular-->
    <form action="index.php" method="post">
        <select name="kriterium" id="kriterium">
            <option value="titel" name="titel">Titel</option>
            <option value="autor" name="autor">Autor</option>
            <option value="genre" name="genre">Genre</option>
            <option value="buchnr" name="buchnr">Buchnummer</option>
        </select>
        <input type="text" name="suchbegriff">
        <input type="submit" value="Suchen" name="suchen">
    </form>
    <?php 

    //Suchabfrage und Ausgabe der Ergebnisse
    if(isset($_POST["suchen"])){
    $kriterium = $_POST["kriterium"];
    $suchbegriff = $_POST["suchbegriff"];
    $verbindung = mysqli_connect("localhost","root","","Buecherei")
    or die(mysqli_connect_error());
    $sql = "SELECT * FROM t_buecher WHERE $kriterium LIKE '$suchbegriff%';";
    $result = mysqli_query($verbindung,$sql);
        echo "<table id='suchergebnis'>";
        echo "<th>Buchnr</th>";
        echo "<th>Titel</th>";
        echo "<th>Beschreibung</th>";
        echo "<th>Autor</th>";
        echo "<th>Genre</th>";
    while($row = mysqli_fetch_array($result)){
        echo "<tr><td>".$row['buchnr']."</td>";
        echo "<td>".$row['titel']."</td>";
        echo "<td>".$row['beschreibung']."</td>";
        echo "<td>".$row['autor']."</td>";   
        echo "<td>".$row['genre']."</td></tr><br>";
    }
    echo "</table>"; 
    }
    ?>
    <h3>Für Bibliothekare</h3>
    <a href="anmeldung.php">Zum Anmelden</a>
</body>
</html>