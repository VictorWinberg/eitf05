<?php session_start(); ?>
<?php require 'connect.php' ?>

<!-- Get orders from database -->
<?php
$orders = $conn->query('SELECT *
						FROM Orders
						INNER JOIN Items
						ON Items.id = Orders.itemId
						WHERE userId=(SELECT id
									  FROM Users
									  WHERE username="'. $_SESSION['username'] .'")
						ORDER BY Orders.timePlaced');
?>

<html>
	<?php require_once('header.php'); ?>
	<body>

		<?php require_once('navigationBar.php'); ?>

		<h1>Ordrar</h1>

		<table>
			<tr>
				<th>Namn</th>
				<th>Pris</th>
				<th>Beställd</th>
			</tr>
			<?php foreach($orders as $order) { ?>
				<tr>
					<td><?= $order['name'] ?></td>
					<td><?= $order['price'] ?></td>
					<td><?= $order['timePlaced'] ?></td>
				</tr>
			<?php } ?>
		</table>

	</body>
</html>
