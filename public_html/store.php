<?php
 session_start(); 
 if (!isset($_SESSION['logged_in'])) {
	 header("location: login.php");
 }
?>


<?php

// TODO Dummy data
$products = array(
	array("id" => 1, "name" => "Fidget spinner", "price" => 0.90),
	array("id" => 2, "name" => "Fidget spinner edition", "price" => 1999.9),
	array("id" => 3, "name" => "Mjölk", "price" => 10.79)
);

?>

<html>
	<?php require_once('header.php'); ?>
	<body>

		<?php require_once('navigationBar.php'); ?>
		<h1> Hejsan: <?=$_SESSION["username"];?> </h1>
		<h1>Produkter</h1>

		<form>
			<table>
				<tr>
					<th>Namn</th>
					<th>Pris</th>
				</tr>
				<?php foreach($products as $product) { ?>
					<tr>
						<td><?= $product['name'] ?></td>
						<td><?= $product['price'] ?></td>
						<td><input type="checkbox" value="<?= $product['id'] ?>"></td>
					</tr>
				<?php } ?>
			</table>
			<br/>
			<input type="submit" value="Lägg till i varukorgen">
		</form>

	</body>
</html>
