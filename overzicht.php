<?php
include 'connector.php';
session_start();
$_SESSION["vertrek"];
$_SESSION["aankomst"];
$_SESSION['dag'];

$sql = $pdo->prepare("SELECT * FROM verkochten_tickets WHERE id = :id");
$sql->bindParam("id", $_SESSION["id_vlucht"]);
$sql->execute();
$Resultaat = $sql->fetchAll();
$persoon = $Resultaat;

$_SESSION['email'] = $Resultaat[0]['email'];

if (isset($_POST["submit"])) {
    $sql2 = $pdo->prepare("SELECT * FROM vluchten WHERE vertrek_locatie = :vertrek AND aankomst_locatie = :aankomst AND datum = :datum");
    $sql2->bindParam("vertrek", $_SESSION["vertrek"]);
    $sql2->bindParam("aankomst", $_SESSION["aankomst"]);
    $sql2->bindParam("datum", $_SESSION['dag']);
    $sql2->execute();
    $Resultaat2 = $sql2->fetchAll();

    echo $Resultaat2[0]['overige_zitplekken'];
    $newzit = $Resultaat2[0]['overige_zitplekken'] -1;
    echo $newzit;

    $sql3 = $pdo->prepare("UPDATE vluchten SET
            overige_zitplekken = :overige_zitplekken
        WHERE vertrek_locatie = :vertrek AND aankomst_locatie = :aankomst AND datum = :datum");

    $sql3->bindParam("vertrek", $_SESSION["vertrek"]);
    $sql3->bindParam("aankomst", $_SESSION["aankomst"]);
    $sql3->bindParam("datum", $_SESSION['dag']);
    $sql3->bindParam(':overige_zitplekken', $newzit);

    $sql3->execute();

    $output = '';

    $who = $_SESSION['email'];
    shell_exec("/usr/bin/python3 ./sendemail.py \"$who\" ");

    exec('/usr/bin/python3 ./sendemail.py', $output);
    var_dump($output);

    header('Location: bevestiging.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Booking Confirmation</title>
    <link rel="stylesheet" href="css.css">
</head>

<body>
<a href="index.html" style="text-decoration: none;color: white;">Home</a>
    <div class="container">
        <h2>Ticket Booking Confirmation</h2>
        <ul>
            <li>
                <label for="name">Name:</label>
                <p><?php echo $Resultaat[0]['name'] ?></p>
            </li>

            <li>
                <label for="surname">Surname:</label>
                <p><?php echo $Resultaat[0]['surname'] ?></p>
            </li>

            <li>
                <label for="vertrek_locatie">Departure Location:</label>
                <p><?php echo $Resultaat[0]['vertrek_locatie'] ?></p>
            </li>

            <li>
                <label for="aankomst_locatie">Arrival Location:</label>
                <p><?php echo $Resultaat[0]['aankomst_locatie'] ?></p>
            </li>

            <li>
                <label for="vertrek_tijd">Departure Time:</label>
                <p><?php echo $Resultaat[0]['vertrek_tijd'] ?></p>
            </li>

            <li>
                <label for="aankomst_tijd">Arrival Time:</label>
                <p><?php echo $Resultaat[0]['aankomst_tijd'] ?></p>
            </li>

            <li>
                <label for="baggage">Luggage:</label>
                <p><?php echo $Resultaat[0]['baggage'] ?></p>
            </li>

            <li>
                <label for="datum">Date:</label>
                <p><?php echo $Resultaat[0]['datum'] ?></p>
            </li>

            <li>
                <label for="prijs">Departure transport:</label>
                <p><?php echo $Resultaat[0]['transport_heenweg'] ?></p>
            </li>

            <li>
                <label for="prijs">Arrival transport:</label>
                <p><?php echo $Resultaat[0]['transport_terugweg'] ?></p>
            </li>

            <li>
                <label for="prijs">Total Price:</label>
                <p><?php echo $Resultaat[0]['prijs'] ?></p>
            </li>
        </ul>
    </div>

    <div class="disclaimer-container">
        <h2>Terms and Conditions</h2>
        <p>Please read the following terms and conditions carefully before using this website:</p>
        <ul>
            <li>The content of this website is for general information purposes only.</li>
            <li>Use of any information or materials on this website is entirely at your own risk.</li>
            <li>This website contains material which is owned by or licensed to us.</li>
            <li>Unauthorized use of this website may give rise to a claim for damages and/or be a criminal offence.</li>
        </ul>

        <form action="overzicht.php" method="POST">
            <input type="checkbox" name="agree" required> I agree to the terms and conditions<br><br>
            <button type="submit" name="submit" id="run-button">Confirm and Pay</button>
        </form>
    </div>
</body>

</html>