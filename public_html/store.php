<?php
 session_start(); 
 if (!isset($_SESSION['logged_in'])) {
	 header("location: login.php");
 }
?>


<?php

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
