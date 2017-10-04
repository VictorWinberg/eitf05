<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
	header("location: index.php");
}
?>

<?php require 'connect.php' ?>

<?php

$method = $_SERVER["REQUEST_METHOD"];

if($method == "POST" && isset($_SESSION['csrf_token']) && isset($_POST['csrf_token']) && $_SESSION['csrf_token'] == $_POST['csrf_token']) {
	if (!isset($_SESSION['logged_in'])) {
		exit();
	}
	$action = $_POST['action'];
	$name = htmlspecialchars($_POST['name']);

	if($action == "ADD") {
		$price = htmlspecialchars($_POST['price']);

		// Prepared statement
		$stmt = $conn->prepare("INSERT INTO items (name, price) VALUES (?, ?)");

		// Bind $name and $price params as strings
		$stmt->bind_param('ss', $name, $price);

		$stmt->execute();
		$stmt->close();
	} elseif ($action == "DELETE") {
		// Prepared statement
		$stmt = $conn->prepare("DELETE FROM items WHERE name = ?");

		// Bind $name param as a string
		$stmt->bind_param('s', $name);

		$stmt->execute();
		$stmt->close();
	}
}

?>

<html>
	<?php require_once('header.php'); ?>
	<body>

		<?php require_once('navigationBar.php'); ?>

		<h1>Hantera produkter</h1>

		<h3>Lägg till produkt</h3>

		<form action="" method="POST">
			<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
			 <input type="hidden" name="action" value="ADD">
			 <label><b>Namn:</b></label>
			 <input type="text" name="name"/>
			 <br /><br />
			 <label><b>Pris:</b></label>
			 <input type="number" name="price"/>
			 <br /><br />
			 <button class="btn" type="submit">Lägg till</button>
		</form>

		<h3>Ta bort produkt</h3>

		<form action="" method="POST">
			<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
			 <input type="hidden" name="action" value="DELETE">
			 <label><b>Namn:</b></label>
			 <input type="text" name="name"/>
			 <br /><br />
			 <button class="btn" type="submit">Ta bort</button>
		</form>

	</body>
</html>
