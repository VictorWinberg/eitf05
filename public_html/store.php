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

	// Add items to shopping cart
	if (isset($_POST['add'])) {
		foreach ($_POST['itemIds'] as $itemId => $quantity) {
			if ($quantity == 0) {
				continue;
			}
			$_SESSION['shopping_cart'][$itemId] = isset($_SESSION['shopping_cart'][$itemId]) ? $_SESSION['shopping_cart'][$itemId] + $quantity : $quantity;
		}
		updateTotalPrice($conn);
	}
}
?>

<!-- Get items from database -->
<?php $items = $conn->query('SELECT * FROM Items'); ?>

<html>
	<?php require_once('header.php'); ?>
	<body>

		<?php require_once('navigationBar.php'); ?>

		<h1>Products</h1>

		<form method="post">
			<table>
				<tr>
					<th>Name</th>
					<th>Price</th>
					<th>Amount</th>
				</tr>
				<?php foreach($items as $item) { ?>
					<tr>
						<td><?= $item['name'] ?></td>
						<td><?= $item['price'] ?> SEK</td>
						<td><input type="number" min="0" name="itemIds[<?= $item['id'] ?>]" value=0></td>
					</tr>
				<?php } ?>
			</table>
			<br/>
			<button class="btn" type="submit" name="add">Add to Shopping Cart</button>
			<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
		</form>

	</body>
</html>
