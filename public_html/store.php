<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
	header("location: login.php");
}
?>

<?php

// Add items to shopping cart
if (isset($_POST['submit'])) {
	foreach ($_POST['itemIds'] as $itemId => $quantity) {
		if ($quantity == 0) {
			continue;
		}
		$_SESSION['shopping_cart'][$itemId] = isset($_SESSION['shopping_cart'][$itemId]) ? $_SESSION['shopping_cart'][$itemId] + $quantity : $quantity;
	}
}

?>

<?php require 'connect.php' ?>

<!-- Get items from database -->
<?php $items = $conn->query('SELECT * FROM Items'); ?>

<html>
	<?php require_once('header.php'); ?>
	<body>

		<?php require_once('navigationBar.php'); ?>

		<h1>Produkter</h1>

		<form method="post">
			<table>
				<tr>
					<th>Namn</th>
					<th>Pris</th>
					<th>Antal</th>
				</tr>
				<?php foreach($items as $item) { ?>
					<tr>
						<td><?= $item['name'] ?></td>
						<td><?= $item['price'] ?></td>
						<td><input type="text" name="itemIds[<?= $item['id'] ?>]" value=0></td>
					</tr>
				<?php } ?>
			</table>
			<br/>
			<input type="submit" name="submit" value="Lägg till i varukorgen">
		</form>

	</body>
</html>
