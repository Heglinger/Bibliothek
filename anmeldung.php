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
    <title>Anmelden</title>
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

        form {
            background-color: #ffffff;
            padding: 20px;
            max-width: 400px;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin: 8px 0 12px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
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

    if (isset($_POST["anmelden"])) {
        $benutzername = $_POST["benutzername"];
        $passwort = $_POST["passwort"];

        $verbindung = mysqli_connect("localhost", "root", "", "buecherei")
            or die(mysqli_connect_error());

        $sql = "SELECT * FROM t_bibliothekar WHERE benutzername = ? AND passwort = ?";
        $stmt = mysqli_prepare($verbindung, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $benutzername, $passwort);
        mysqli_stmt_execute($stmt);
        $ergebnis = mysqli_stmt_get_result($stmt);
        // Überprüfung ob ein Ergebnis zurückgegeben wurde
        if (mysqli_num_rows($ergebnis) != 0) {
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