<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
	header("location: login.php");
}
?>

<?php
	require 'connect.php';
	require 'utility.php';
?>

<!-- Get shopping cart array -->
<?php $cart = getCart($conn); ?>

<html>
	<?php require_once('header.php'); ?>
	<body>

		<?php require_once('navigationBar.php'); ?>

		<h1>Bekräftelse</h1>

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
					<td><?= $item['quantity'] ?></td>
					<td><?= $item['price'] * $item['quantity'] ?></td>
				</tr>
			<?php } ?>
		</table>
		<p>
			<b>Summa:</b> <?= $_SESSION["total_price"] ?>
		</p>
		<p>
			Tack för att du handlar med Fidget Express :-)
		</p>

	</body>
</html>
