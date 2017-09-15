<?php $site = basename($_SERVER['PHP_SELF']); ?>
<div class="navigationBar">
	<a href="store.php"<?php if($site == "store.php"){ echo 'class="active"'; } ?>>Produkter</a>
	<a href="logout.php">Logga ut</a>
	<a href="profile.php"<?php if($site == "profile.php"){ echo 'class="active"'; } ?>>Min profil (<?= $_SESSION['username'] ?>)</a>
	<a href="cart.php"<?php if($site == "cart.php"){ echo 'class="active"'; } ?>>Kundvagn</a>
</div>
