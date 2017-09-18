<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
	header("location: login.php");
}
?>

<?php require 'connect.php' ?>

<?php

// Update the item quantity in the shopping cart
if (isset($_POST['quantity'])) {
	$_SESSION['shopping_cart'][$_POST['itemId']] = $_POST['quantity'];
}

// Remove the item from the shopping cart
if (isset($_POST['remove'])) {
	unset($_SESSION['shopping_cart'][$_POST['itemId']]);
}

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
							<form method="post">
								<td><input type="text" name="quantity" value="<?= $item['quantity'] ?>"></td>
								<input type="hidden" name="itemId" value="<?= $item['id'] ?>">
							</form>
							<td><?= $item['price'] * $item['quantity'] ?></td>
							<form method="post">
								<td><input type="submit" name="remove" value="Ta bort"></td>
								<input type="hidden" name="itemId" value="<?= $item['id'] ?>">
							</form>
						</tr>
				<?php } ?>
			</table>
			<p>
				<b>Summa:</b> <?= $total ?>
			</p>
			<input type="submit" name="pay" value="Betala">

		<?php } else { ?>

			<p>Inga produkter</p>

		<?php } ?>

	</body>
</html>
