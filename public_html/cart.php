<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
	header("location: login.php");
}
?>

<?php require 'connect.php' ?>

<?php

// Get items in shopping cart
$result = $conn->query('SELECT *
					  	FROM Items
					  	WHERE id
					  	IN ('. implode(",", array_keys($_SESSION['shopping_cart'])) .')
					  	GROUP BY id');

// Create cart
$cart = array();
if ($result) {
	while ($row = $result->fetch_assoc()) {
		$row['quantity'] = $_SESSION['shopping_cart'][$row['id']];
		$cart[] = $row;
	}
}

// Count the total price of all items
$total = 0;
foreach($cart as $item) {
	$total += ($item['price'] * $item['quantity']);
}

?>

<html>
	<?php require_once('header.php'); ?>
	<body>

		<?php require_once('navigationBar.php'); ?>

		<h1>Kundvagn</h1>

		<?php if ($cart) { ?>

			<form>
				<table>
					<tr>
						<th>Namn</th>
						<th>Á-pris</th>
						<th>Antal</th>
						<th>Totalt</th>
					</tr>
					<?php foreach($cart as $item) { ?>
						<tr>
							<td><?= $item['name'] ?></td>
							<td><?= $item['price'] ?></td>
							<td><input type="text" value="<?= $item['quantity'] ?>"></td>
							<td><?= $item['price'] * $item['quantity'] ?></td>
							<td><input type="submit" value="Ta bort"></td>
						</tr>
					<?php } ?>
				</table>
				<p>
					<b>Summa:</b> <?= $total ?>
				</p>
				<input type="submit" value="Betala">
			</form>

		<?php } else { ?>

			<p>Inga produkter</p>

		<?php } ?>

	</body>
</html>
