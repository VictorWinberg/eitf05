<?php require 'connect.php' ?>

<link rel="stylesheet" href="css/index.css" />

<!-- Get items from database -->
<?php $items = $conn->query('SELECT * FROM Items'); ?>

<html>
	<?php require_once('header.php'); ?>
	<body>

		<?php require_once('navigationBar.php'); ?>

		<h1>Produkter</h1>

		<form>
			<table>
				<tr>
					<th>Namn</th>
					<th>Pris</th>
				</tr>
				<?php foreach($items as $item) { ?>
					<tr>
						<td><?= $item['name'] ?></td>
						<td><?= $item['price'] ?></td>
						<td><input type="checkbox" value="<?= $item['id'] ?>"></td>
					</tr>
				<?php } ?>
			</table>
			<br/>
			<input type="submit" value="Lägg till i varukorgen">
		</form>

	</body>
</html>
