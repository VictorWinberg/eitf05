<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
	header("location: index.php");
} else if (!isset($_SESSION["total_price"]) || $_SESSION["total_price"] == "0"){
    header("location: store.php");
}
?>

<?php
	require 'connect.php';
	require 'utility.php';
?>

<?php

$error = false;
$cart = array();
if (isset($_POST["pay"]) && isset($_SESSION['csrf_token']) && isset($_POST['csrf_token']) && $_SESSION['csrf_token'] == $_POST['csrf_token']) {
	if (!isset($_SESSION['logged_in'])) {
		exit();
	}
	// Adding a 10 percent failure rate on payment
	if (rand(1, 100)<= 10) {
		$error = true;
	} else if (count($_SESSION["shopping_cart"]) > 0) {
		foreach ($_SESSION["shopping_cart"] as $itemId => $quantity) {
			for ($i=0; $i<$quantity; $i++) {

				// Prepared statement
				$stmt = $conn->prepare("INSERT INTO orders (userId, itemId) VALUES (?, ?)");

				// Bind user id and item id params as ints
				$stmt->bind_param('ii', $_SESSION['login_user']["id"], $itemId);

				$stmt->execute();
				$stmt->close();

			}
		}
		$cart = getCart($conn);
		$_SESSION["shopping_cart"] = array();
	}

}

?>

<html>
	<?php require_once('header.php'); ?>
    <body>

    	<?php require_once('navigationBar.php'); ?>

    	<?php if (count($cart) == 0) { ?>

		    <h1> Payment </h1>
            <h4> Please enter your credit card details </h4>
            <h4> To see a summary of all selected items, press Shopping Cart above </h4>

            <form method="post">
                <h2> Card number: </h2>
                <input type="text">
                <h4> Month/Year </h4>
                <input type="text"> <input type="text">
                <p>
                	<?php echo "Att betala: <b>", $_SESSION["total_price"], "</b> kr <t>"; ?>
                </p>
                <button class="btn" name="pay">Perform Payment</button>
                <p class="error">
                	<?= $error ? "Din betalning lyckades ej. Var god försök igen!" : ""; ?>
                </p>
		<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            </form>

        <?php } else { ?>

			<h1>Confirmation</h1>

			<table>
				<tr>
					<th>Name</th>
					<th>Price per piece</th>
					<th>Amount</th>
					<th>Total</th>
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
				<b>Total Sum:</b> <?= $_SESSION["total_price"] ?>
			</p>
			<p>
				Thank you for shopping with fidget express!
			</p>

			<?php updateTotalPrice($conn); ?>

        <?php } ?>

    </body>
</html>
