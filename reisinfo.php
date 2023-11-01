<?php
include 'connector.php';
session_start();
$_SESSION["loggedInUser"];

if (isset($_POST["inlog"])) {
    $_SESSION["vertrek"] = $_POST["vertrek"];
    $_SESSION["aankomst"] = $_POST["aankomst"];
    $_SESSION["datum"] = $_POST["datum"];

    if ($_POST["vertrek"] == $_POST["aankomst"]) {
        echo "<h1 style='color: red; text-align: center;'>Departure and arrival cannot be the same</h1>";
    } else {
        header('Location: keuzevlucht.php');
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="log.css">
</head>
<body>
<a href="index.html" style="text-decoration: none;color: white;">Home</a>
<div class="container">
    <H1 style="color: white;">Determine your flight</H1>
    <form action="reisinfo.php" method="post">
        <label for="vertrek">Departure location</label>
        <select name="vertrek" id="departure" required>
            <option value="Amsterdam">Amsterdam</option>
            <option value="New york">New york</option>
            <option value="Sydney">Sydney</option>
            <option value="Tokyo">Tokyo</option>
            <option value="Dubai">Dubai</option>
        </select>

        <label for="aankomst">Arrival location</label>
        <select name="aankomst" id="arrival" required>
            <option value="Amsterdam">Amsterdam</option>
            <option value="New york">New york</option>
            <option value="Sydney">Sydney</option>
            <option value="Tokyo">Tokyo</option>
            <option value="Dubai">Dubai</option>
        </select>

        <label for="datum">Date</label>
        <input type="date" name='datum' required>

        <button type="submit" value="Book Now" name="inlog">Submit</button>
    </form>
</div>
</body>
</html>