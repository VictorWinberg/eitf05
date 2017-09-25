<?php

function debug($msg) {
  $msg = print_r($msg, true);
  echo '<script>console.log(' . json_encode($msg) . ')</script>';
}

// Gets the cart array
function getCart($conn) {

	// Get items in shopping cart
	$result = $conn->query('SELECT *
						  	FROM Items
						  	WHERE id
						  	IN ('. implode(",", array_keys($_SESSION['shopping_cart'])) .')
						  	GROUP BY id');

	// Create cart
	$cart = array();
	if ($result) {
		while ($row = $result->fetch_assoc()) {
			$row['quantity'] = $_SESSION['shopping_cart'][$row['id']];
			$cart[] = $row;
		}
	}

	return $cart;

}

// Updates the total price of the shopping card and saves it to a SESSION variable
function updateTotalPrice($conn) {

	// Get shopping cart array
	$cart = getCart($conn);

	// Count the total price of all items
	$total = 0;
	foreach($cart as $item) {
		$total += ($item['price'] * $item['quantity']);
	}
	$_SESSION["total_price"] = $total;

}

?>
