<?php $site = basename($_SERVER['PHP_SELF']) ?>
<div class="navigationBar">
	<a href="store.php" class="<?= $site == 'store.php' ? 'active' : '' ?>">
		Produkter
	</a>
	<a href="logout.php">
		Logga ut
	</a>
	<a href="profile.php" class="<?= $site == 'profile.php' ? 'active' : '' ?>">
		Min profil (<?= $_SESSION['login_user']['name'] ?>)
	</a>
	<a href="cart.php" class="<?= $site == 'cart.php' ? 'active' : '' ?>">
		Kundvagn
	</a>
	<a href="review.php"<?= $site == "review.php" ? 'class="active"' : '' ?>>
		Reviews
	</a>
</div>
