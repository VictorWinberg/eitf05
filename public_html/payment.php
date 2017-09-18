<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
	header("location: login.php");
} else if (!isset($_SESSION["total_price"]) or $_SESSION["total_price"] == "0"){
    header("location: store.php");
}
?>

<html>
	<?php require_once('header.php'); ?>
        <body>
        	<?php require_once('navigationBar.php'); ?>
            <form>
                <h1> Betalning </h1>
                <h4> Var god och ange dina kreditkortsuppgifter. </h4> 
                <h4> För att se en sammanfattning på dina varor, var god klicka på "Kundvagn". </h4>
                <h2> Kortnummer: </h2>
                <input type="text">
                <h4> datum/månad </h4>
                <input type="text"> <input type="text">
                <br>
                <br>
                <?php echo "Att betala: <b>", $_SESSION["total_price"], "</b> kr <t>"; ?>
                <input type="button" value="Utför betalning" onclick="return createPayment()" > 
            </form>
        </body>
        <script type='text/javascript'>
        function createPayment() 
        {
        // Adding 10 percent failure rate on payment
            var randomSuccess=Math.floor((Math.random() * 10));
            if (randomSuccess < 1) {
                alert("Din betalning var lyckades ej. Var god försök igen!")
            } else {
                // Byta till kvitto när det är klart
                window.location = '/store.php';
            }
        }
        </script>
</html>