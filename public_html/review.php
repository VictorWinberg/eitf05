<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
	header("location: index.php");
}
?>

<?php
require 'connect.php';
require 'utility.php';

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['csrf_token']) &&
isset($_POST['csrf_token']) && $_SESSION['csrf_token'] == $_POST['csrf_token']) {
	if (!isset($_SESSION['logged_in'])) {
		exit();
  }

  $subject = htmlspecialchars($_POST['subject'], ENT_QUOTES);
  $review = htmlspecialchars($_POST['review'], ENT_QUOTES);
  $username = $_SESSION['login_user']['name'];

  $sql = "INSERT INTO Reviews (name, subject, review)
  VALUES (?,?,?)";

  if($statement=$conn->prepare($sql)) {
    $statement->bind_param("sss", $username, $subject, $review);

		if(!$statement->execute())
      $error = "Unable to submit the review, please try again.";

  } else {
    $error = "Unable to submit the review, please try again.";
  }
}
?>

<!-- Get reviews from database -->
<?php $reviews = getReviews($conn); ?>

<html>
  <body>
    <?php require('header.php'); ?>

    <form action="" method="POST">
      <?php require('navigationBar.php'); ?>

      <h3>Leave your review of Fidget Express here:</h3>

      <input type="text" name="subject" placeholder="Subject" maxlength="40"/>
      <br/><br />
      <textarea name='review' rows="5" cols="80" id='comment'></textarea><br />
      <br/><br />
      <button class="btn" style="width: 250" type="submit">Submit</button>
      <br/><br />

      <?php if (count($reviews)) { ?>
        <?php foreach($reviews as $item) {
          $date=explode(" ", $item['ts']);
          $rev=rtrim($item['review']);
          $topline="Subject: ".$item['subject']." - Posted: ".$date[0]." - By: ".$item['name'];?>
          <p> <?=print_r($topline, true) ?></p>
          <div class="reviews">
            <p><?= print_r($rev, true) ?></p>
          </div>
        <?php } ?>
      <?php } ?>

      <p style="font-size: 0.8em; color: DarkSlateGray"></p>
      <p class="small" style="font-size: 0.8em; color:red">
        <?php if(isset($error)) echo $error; ?>
      </p>
      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    </form>
  </body>
</html>
