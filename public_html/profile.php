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
				<th><h1>Uppgifter</h1></th>
			</tr>
			<tr>
				<th>Användarnamn</th>
				<td><?= $LOGIN_USER['username'] ?></td>
			</tr>
			<tr>
				<th>Namn</th>
				<td><?= $LOGIN_USER['name'] ?></td>
			</tr>
			<tr>
				<th>Adress</th>
				<td><?= $LOGIN_USER['address'] ?></td>
			</tr>
		</table>

		<h1>Ordrar</h1>

		<?php if (mysqli_num_rows($orders)) { ?>

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

		<?php } else { ?>

			<p>Inga ordrar</p>

		<?php } ?>

	</body>
</html>
