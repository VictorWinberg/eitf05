<?php $site = basename($_SERVER['PHP_SELF']); ?>
<div class="navigationBar">
	<a href="store.php"<?= $site == "store.php" ? 'class="active"' : '' ?>>
		Produkter
	</a>
	<a href="logout.php">
		Logga ut
	</a>
	<a href="profile.php"<?= $site == "profile.php" ? 'class="active"' : '' ?>>
		Min profil (<?= $_SESSION['username']?>)
	</a>
	<a href="cart.php"<?= $site == "cart.php" ? 'class="active"' : '' ?>>
		Kundvagn
	</a>
	<a href="edit.php"<?= $site == "edit.php" ? 'class="active"' : '' ?>>
		Hantera
	</a>
</div>
