<?php
//welcome.php

require_once 'includes/global.inc.php';

//check to see if they're logged in
if(!isset($_SESSION['logged_in'])) {
	header("Location: login.php");
}

//get the user object from the session
$user = unserialize($_SESSION['user']);

?>

<html>
<head>
	<title>Welcome <?php echo $user->username; ?></title>
	<link rel="stylesheet" href="css/bootstrap.css"  type="text/css">
	<link rel="shortcut icon" href="http://www.uvm.edu/~jtbrenna/cs142/Final%20Project/FinalProject-Group/favicon.ico">
</head>
<body>
	<!--This is the bootstrap framework for our site, subject to change, obvioiusly.  replace hrefs leading to "#" with their actual targets as we build them"-->

	<div class="container">

	<?php
	if(isset($_SESSION['logged_in'])){
		include 'includes/nav-in.php'; 
	} else {
		include 'includes/nav.php';
	}
	?>
	
	<div class="hero-unit">
    	<h2>Welcome to Blog Diggity</h2>
 		<p>Hey there, <?php echo $user->username; ?>. You've been registered and logged in. Welcome! <a href="logout.php">Log Out</a> | <a href="index.php">Return to Homepage</a></p>
 
 	</div>
	</div>	<!--Main container-->

		<!--Import jquery and bootstrap-->
		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="js/bootstrap.js"></script>
<div id="image"><a href="mailto:bmcomber@uvm.edu?Subject=Ad%20Space" target="_top"><img src="http://www.uvm.edu/~bmcomber/cs142/assignment7/Content_Blog/FinalProject-Group/img/YourAdHere.png" alt="Your Ad Here"></a></div>
<?PHP include('includes/footer.php');?>
</body>
</html>