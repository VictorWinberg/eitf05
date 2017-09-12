<link rel="stylesheet" href="css/index.css" />

<?php

// TODO Dummy data
$cart = array(
	array("id" => 1, "name" => "Fidget spinner", "price" => 0.90, "quantity" => 1),
	array("id" => 2, "name" => "Fidget spinner edition", "price" => 1999.9, "quantity" => 2),
	array("id" => 3, "name" => "Mjölk", "price" => 10.79, "quantity" => 4)
);

$total = 0;
foreach($cart as $item) {
	$total += ($item["price"] * $item["quantity"]);
}

?>

<html>
	<?php require_once('header.php'); ?>
	<body>

		<?php require_once('navigationBar.php'); ?>

		<h1>Kundvagn</h1>

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
						<td><input type="text" value="<?= $item['quantity'] ?>"></td>
						<td><?= $item['price'] * $item['quantity'] ?></td>
						<td><input type="submit" value="Ta bort"></td>
					</tr>
				<?php } ?>
			</table>
			<p>
				<b>Summa:</b> <?= $total ?>
			</p>
			<input type="submit" value="Betala">
		</form>

	</body>
</html>
