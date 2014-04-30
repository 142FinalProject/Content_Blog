<?php 

require_once 'includes/global.inc.php';

//check to see if they're logged in
if(!isset($_SESSION['logged_in'])) {
	header("Location: login.php");
}

//get the user object from the session
$user = unserialize($_SESSION['user']);

//initialize php variables used in the form
$email = $user->email;
$message = "";

//check to see that the form has been submitted
if(isset($_POST['submit-settings'])) { 

	//retrieve the $_POST variables
	$email = $_POST['email'];

	$user->email = $email;
	$user->save();

	$message = "Settings Saved<br/>";
}

//If the form wasn't submitted, or didn't validate
//then we show the registration form again
?>

<html>
<head>
	<title>Change Settings</title>
	<link rel="stylesheet" href="css/bootstrap.css"  type="text/css">
</head>
<body>
	<div class="container">
	<h1><a href="#">Blog Diggity!</a></h1>

	<?php
	if(isset($_SESSION['logged_in'])){
		include 'includes/nav-in.php'; 
	} else {
		include 'includes/nav.php';
	}
	?>

	<div class="hero-unit">
    	<h2>Settings</h2>

    	<?php echo $message; ?>
    	<?php echo "Current Email Address: " . $email; ?>
		<form action="settings.php" method="post">
			E-Mail: <input type="text" value="" name="email" placeholder="Enter a new email address"/><br/>
			<input type="submit" value="Update" name="submit-settings" />
		</form>
	
 	</div>
	</div>	<!--Main container-->
	
</body>
</html>