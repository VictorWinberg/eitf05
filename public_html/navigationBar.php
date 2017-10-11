<?php $site = basename($_SERVER['PHP_SELF']) ?>
<div class="navigationBar">
	<a href="store.php" class="<?= $site == 'store.php' ? 'active' : '' ?>">
		Products
	</a>
	<a href="logout.php">
		Logout
	</a>
	<a href="profile.php" class="<?= $site == 'profile.php' ? 'active' : '' ?>">
		My profile (<?= $_SESSION['login_user']['name'] ?>)
	</a>
	<a href="cart.php" class="<?= $site == 'cart.php' ? 'active' : '' ?>">
		Shopping Cart
	</a>
	<a href="review.php"<?= $site == "review.php" ? 'class="active"' : '' ?>>
		Reviews
	</a>
</div>
