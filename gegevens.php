<?php
include 'connector.php';
session_start();
$_SESSION["ticket_id"];
$_SESSION["loggedInUser"];
$_SESSION["vertrek"];
$_SESSION["aankomst"];
$_SESSION["datum"];
$_SESSION['dag'];

$hand = 10;
$hand20 = 20;
$hand30 = 30;


$sql = $pdo->prepare("SELECT * FROM id_spacex WHERE id = :id");
$sql->bindParam("id", $_SESSION["loggedInUser"]);
$sql->execute();
$Resultaat = $sql->fetchAll();
$persoon = $Resultaat;

if (isset($_POST["submit"])) {
	if ($_POST['baggage'] == "Hand baggage") {
		$prijs = $hand + $_SESSION['prijs'];
	} elseif ($_POST['baggage'] == "Hand + 20kg") {
		$prijs = $hand20 + $_SESSION['prijs'];
	} elseif ($_POST['baggage'] == "Hand + 30kg") {
		$prijs = $hand30 + $_SESSION['prijs'];
	} else {
		echo "klopt ni";
	}

	$_SESSION['nummer'] = $_POST['phone'];
	$_SESSION['baggage'] = $_POST['baggage'];

	$sql1 = $pdo->prepare("INSERT INTO verkochten_tickets SET 
		id_persoon = :id, 
		name = :name,
		surname = :surname,
		email = :email,
		telefoonnummer = :nummer,
		vertrek_locatie = :vertrek_locatie,
		aankomst_locatie = :aankomst_locatie,
		vertrek_tijd = :vertrek_tijd,
		aankomst_tijd = :aankomst_tijd,
		baggage = :baggage,
		datum = :datum,
		prijs = :prijs,
		transport_heenweg = :transporth,
		transport_terugweg = :transportt
		");

		$sql1->bindParam(':id', $_SESSION["loggedInUser"]);
		$sql1->bindParam(':name', $persoon[0]['name']);
		$sql1->bindParam(':surname', $persoon[0]['surname']);
		$sql1->bindParam(':email', $persoon[0]['email']);
		$sql1->bindParam(':nummer', $_POST['phone']);
		$sql1->bindParam(':vertrek_locatie', $_SESSION["vertrek"]);
		$sql1->bindParam(':aankomst_locatie', $_SESSION["aankomst"]);
		$sql1->bindParam(':vertrek_tijd', $_SESSION['vertrek_tijd']);
		$sql1->bindParam(':aankomst_tijd', $_SESSION['aankomst_tijd']);
		$sql1->bindParam(':baggage', $_POST['baggage']);
		$sql1->bindParam(':datum', $_SESSION["datum"]);
		$sql1->bindParam(':prijs', $prijs);
		$sql1->bindParam(':transporth', $_POST['transporth']);
		$sql1->bindParam(':transportt', $_POST['transportt']);
		if ($sql1->execute()) {
			$sql2 = $pdo->prepare("SELECT * FROM verkochten_tickets WHERE id_persoon = :id_persoon AND telefoonnummer= :telefoonnummer AND vertrek_locatie= :vertrek_locatie AND aankomst_locatie= :aankomst_locatie AND datum = :datum");
            $sql2->bindParam("id_persoon", $_SESSION["loggedInUser"]);
            $sql2->bindParam("telefoonnummer", $_POST['phone']);
			$sql2->bindParam("vertrek_locatie", $_SESSION["vertrek"]);
			$sql2->bindParam("aankomst_locatie", $_SESSION["aankomst"]);
			$sql2->bindParam("datum", $_SESSION["datum"]);
            $sql2->execute();
            $Resultaat = $sql2->fetchAll();
			
            $_SESSION["id_vlucht"] = $Resultaat[0]['id'];
			header('location: overzicht.php');
		}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Ticket Booking</title>
    <link rel="stylesheet" href="gegevens.css">

</head>
<body>
<a href="index.html" style="text-decoration: none;color: white;">Home</a>
	<div class="container">
		<h1>Ticket Booking</h1>
		<form action="gegevens.php" method='POST'>
			<label for="name">Name:</label>
			<input type="text" id="name" name="name" placeholder=<?php echo $persoon[0]['name'] ?>>

			<label for="surname">Surname:</label>
			<input type="text" id="surname" name="surname" placeholder=<?php echo $persoon[0]['surname'] ?>>

			<label for="email">Email:</label>
			<input type="email" id="email" name="email" placeholder=<?php echo $persoon[0]['email'] ?>>

			<label for="phone">Phone number:</label>
			<input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>

			<label for="baggage">Baggage:</label>
			<select id="baggage" name="baggage">
				<option value="">Select baggage option</option>
				<option value="Hand baggage">Hand baggage</option>
				<option value="Hand + 20kg">Hand + 20kg</option>
				<option value="Hand + 30kg">Hand + 30kg</option>
			</select>

			<!-- <label for="arrival">Arrival transport:</label>
			<select id="arrival" name="arrival">
				<option value="">Select arrival transport</option>
				<option value="Flight">Flight</option>s
				<option value="Train">Train</option>
				<option value="Bus">Bus</option>
			</select> -->

			<label for="departure">Departure transport:</label>
<?php
		if ($_SESSION["vertrek"] == 'Amsterdam' || $_SESSION["vertrek"] == 'New york') {
?>
			<select id="arrival" name="transporth" require>
				<option value="">Select arrival transport</option>
				<option value="VIP helicopter">VIP helicopter</option>
				<option value="Tesla Model B boat">Tesla Model B boat</option>
			</select>
<?php
		} elseif ($_SESSION["vertrek"] == 'Sydney' || $_SESSION["vertrek"] == 'Dubai') {
?>
			<select id="arrival" name="transporth" require>
				<option value="">Select arrival transport</option>
				<option value="VIP helicopter">VIP helicopter</option>
				<option value="Model X">Model X</option>
			</select>
<?PHP
		}elseif ($_SESSION["vertrek"] == 'Tokyo') {
?>
			<select id="arrival" name="transporth" require>
				<option value="">Select arrival transport</option>
				<option value="Tesla Model B boat">Tesla Model B boat</option>
				<option value="VIP helicopter">VIP helicopter</option>
				<option value="Model X">Model X</option>
			</select>
<?PHP
		}
?>

<label for="departure">Arrival transport:</label>
<?php
		if ($_SESSION["aankomst"] == 'Amsterdam' || $_SESSION["aankomst"] == 'New york') {
?>
			<select id="arrival" name="transportt" require>
				<option value="">Select arrival transport</option>
				<option value="VIP helicopter">VIP helicopter</option>
				<option value="Tesla Model B boat">Tesla Model B boat</option>
			</select>
<?php
		} elseif ($_SESSION["aankomst"] == 'Sydney' || $_SESSION["aankomst"] == 'Dubai') {
?>
			<select id="arrival" name="transportt" require>
				<option value="">Select arrival transport</option>
				<option value="VIP helicopter">VIP helicopter</option>
				<option value="Model X">Model X</option>
			</select>
<?PHP
		} elseif ($_SESSION["aankomst"] == 'Tokyo') {
?>
			<select id="arrival" name="transportt" require>
				<option value="">Select arrival transport</option>
				<option value="Tesla Model B boat">Tesla Model B boat</option>
				<option value="VIP helicopter">VIP helicopter</option>
				<option value="Model X">Model X</option>
			</select>
<?PHP
		}
?>
            <input type="submit" value="submit" name="submit">
		</form>
	</div>
</body>

