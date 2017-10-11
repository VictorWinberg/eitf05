<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
	header("location: index.php");
}
?>

<?php
	require 'connect.php';
	require 'utility.php';
?>

<?php

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['csrf_token']) && isset($_POST['csrf_token']) && $_SESSION['csrf_token'] == $_POST['csrf_token']) {
	if (!isset($_SESSION['logged_in'])) {
		exit();
	}

	// Update the item quantity in the shopping cart
	if (isset($_POST['quantity'])) {
		$_SESSION['shopping_cart'][$_POST['itemId']] = $_POST['quantity'];
		updateTotalPrice($conn);
	}

	// Remove the item from the shopping cart
	if (isset($_POST['remove'])) {
		unset($_SESSION['shopping_cart'][$_POST['itemId']]);
		updateTotalPrice($conn);
	}

}
// Get shopping cart array
$cart = getCart($conn);
?>

<html>
	<?php require_once('header.php'); ?>
	<body>

		<?php require_once('navigationBar.php'); ?>

		<h1>Shopping Cart</h1>

		<?php if (count($cart)) { ?>

			<table>
				<tr>
					<th>Name</th>
					<th>Price per piece</th>
					<th>Amount</th>
					<th>Total</th>
					<th></th>
				</tr>
				<?php foreach($cart as $item) { ?>
					<tr>
						<td><?= $item['name'] ?></td>
						<td><?= $item['price'] ?></td>
						<form method="post">
							<td><input type="number" min="0" name="quantity" value="<?= $item['quantity'] ?>"></td>
							<input type="hidden" name="itemId" value="<?= $item['id'] ?>">
							<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
							<td><?= $item['price'] * $item['quantity'] ?></td>
							<td><button type="submit" /> Update </button> </td>
						</form>
						<form method="post">
							<td><button type="submit" name="remove">Remove</button></td>
							<input type="hidden" name="itemId" value="<?= $item['id'] ?>">
							<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
						</form>
					</tr>
				<?php } ?>
			</table>
			<p>
				<b>Total Sum:</b> <?= $_SESSION["total_price"] ?>
			</p>
			<button class="btn" onClick="return handlePayment()">Checkout</button>

		<?php } else { ?>

			<p>No products</p>

		<?php } ?>

	</body>
	<script type='text/javascript'>
		function handlePayment() {
			window.location = 'payment.php';
			return false;
		}
	</script>
</html>
