<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
	header("location: index.php");
}
$LOGIN_USER = $_SESSION['login_user'];
$username = $LOGIN_USER['username'];
?>

<?php require 'connect.php' ?>

<!-- Get orders from database -->
<?php
$orders = $conn->query("SELECT *
						FROM Orders
						INNER JOIN Items
						ON Items.id = Orders.itemId
						WHERE userId=(SELECT id
									  FROM Users
									  WHERE username='$username')
						ORDER BY Orders.timePlaced");
?>

<html>
	<?php require_once('header.php'); ?>
	<body>

		<?php require_once('navigationBar.php'); ?>

		<table>
			<tr>
				<th><h1>Credentials</h1></th>
			</tr>
			<tr>
				<th>Username</th>
				<td><?= $LOGIN_USER['username'] ?></td>
			</tr>
			<tr>
				<th>Name</th>
				<td><?= $LOGIN_USER['name'] ?></td>
			</tr>
			<tr>
				<th>Adress</th>
				<td><?= $LOGIN_USER['address'] ?></td>
			</tr>
		</table>

		<h1>Orders</h1>

		<?php if (mysqli_num_rows($orders)) { ?>

			<table>
				<tr>
					<th>Name</th>
					<th>Price</th>
					<th>Ordered</th>
				</tr>
				<?php foreach($orders as $order) { ?>
					<tr>
						<td><?= $order['name'] ?></td>
						<td><?= $order['price'] ?> SEK</td>
						<td><?= $order['timePlaced'] ?></td>
					</tr>
				<?php } ?>
			</table>

		<?php } else { ?>

			<p>No previous orders</p>

		<?php } ?>

	</body>
</html>
