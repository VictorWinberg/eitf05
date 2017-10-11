<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
  header("location: index.php");
}
?>

<?php
require 'connect.php';
require 'utility.php';

$title = 'Review - Fidget Express';
$name = $_SESSION['login_user']['name'];

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['csrf_token']) &&
isset($_POST['csrf_token']) && $_SESSION['csrf_token'] == $_POST['csrf_token']) {
  if (!isset($_SESSION['logged_in'])) {
    exit();
  }

  $subject = htmlspecialchars($_POST['subject'], ENT_QUOTES);
  $review = htmlspecialchars($_POST['review'], ENT_QUOTES);

  $sql = "INSERT INTO Reviews (name, subject, review)
  VALUES (?,?,?)";

  if($statement=$conn->prepare($sql)) {
    $statement->bind_param("sss", $name, $subject, $review);

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
  <?php require('header.php'); ?>
  <?php require('navigationBar.php'); ?>

  <body>
    <form action="" method="POST">

      <h3>Leave your review of Fidget Express</h3>

      <input type="text" name="subject" placeholder="Subject" maxlength="40"/>
      <br/><br />
      <textarea name="review" placeholder="This webshop is great because..." rows="5" cols="80" id='comment'></textarea><br />
      <p><b>Author:</b> <?= $name ?>. <b>Date:</b> <?= date('Y-m-j') ?>.</p>
      <button class="btn" style="width: 250" type="submit">Submit</button>
      <br/><br />

      <p style="font-size: 0.8em; color: DarkSlateGray"></p>
      <p style="font-size: 0.8em; color:red">
        <?php if(isset($error)) echo $error; ?>
      </p>
      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    </form>

    <h3>Reviews</h3>
    <hr/>

    <table>
      <tr>
        <th>User</th>
        <th>Review</th>
      </tr>
      <?php if (count($reviews)) { ?>
        <?php foreach($reviews as $item) { ?>
          <?php $date=explode(" ", $item['ts'])[0] ?>
          <tr>
            <td>
              <b style="color: SteelBlue"><?= $item['name'] ?></b><br><br>
              <span style="font-size: 0.8em"><?= $date ?></span><br>
            </td>
            <td style="font-size: 1em; vertical-align: top;">
              <b><?= $item['subject'] ?></b><br>
              <?= rtrim($item['review']) ?></span>
            </td>
          </tr>
        <?php } ?>
      <?php } ?>
    </table>
  </body>
</html>
