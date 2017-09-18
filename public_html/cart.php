<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
	header("location: login.php");
}
?>

<?php 
require 'connect.php';
?>

<?php

// Get items in shopping cart
$cart = $conn->query('SELECT *
					  FROM Items
					  WHERE id
					  IN ('. implode(",", $_SESSION['shopping_cart']) .')
					  GROUP BY id');

// Count the quantities of all items
$quantities = array();
foreach ($_SESSION['shopping_cart'] as $itemId) {
	if (!isset($quantities[$itemId])) {
		$quantities[$itemId] = 1;
	} else {
		$quantities[$itemId]++;
	}
}

// Count the total price of all items
$total = 0;
if ($cart) {
	foreach($cart as $item) {
		$total += ($item["price"] * $quantities[$item["id"]]);
	}
	$_SESSION["total_price"] = $total;
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
							<td><input type="text" value="<?= $quantities[$item["id"]] ?>"></td>
							<td><?= $item['price'] * $quantities[$item["id"]] ?></td>
							<td><input type="submit" value="Ta bort"></td>
						</tr>
					<?php } ?>
				</table>
				<p>
					<b>Summa:</b> <?= $total ?>
				</p>
				<input type="submit" value="Betala" onClick="return handlePayment()" >
			</form>

		<?php } else { ?>

			<p>Inga produkter</p>

		<?php } ?>

	</body>
	<script type='text/javascript' >
	function handlePayment() 
	{
		window.location = '/payment.php';
		return false;
	}
	</script>
</html>
