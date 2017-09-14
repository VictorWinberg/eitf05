<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
	header("location: login.php");
}
?>

<?php

// Add items to shopping cart
if (isset($_POST["submit"])) {
	$_SESSION['shopping_cart'] = array_merge($_POST["itemIds"], $_SESSION['shopping_cart']);
	// TODO Remove abuse with cmd+r
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
				</tr>
				<?php foreach($items as $item) { ?>
					<tr>
						<td><?= $item['name'] ?></td>
						<td><?= $item['price'] ?></td>
						<td><input type="checkbox" name="itemIds[]" value="<?= $item['id'] ?>"></td>
					</tr>
				<?php } ?>
			</table>
			<br/>
			<input type="submit" name="submit" value="Lägg till i varukorgen">
		</form>

	</body>
</html>
