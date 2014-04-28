<?php
//index.php 

require_once 'includes/global.inc.php';
?>

<html>
<head>
	<title>Homepage</title>
	<link rel="stylesheet" href="css/bootstrap.css"  type="text/css">
</head>
<body>
	<!--This is the bootstrap framework for our site, subject to change, obvioiusly.  replace hrefs leading to "#" with their actual targets as we build them"-->

	<div class="container">
	<h1><a href="#">Blog Diggity!</a></h1>

	<?php include 'includes/nav.php'; ?>
	
	<div class="hero-unit">
    	<h2>Welcome to blog Diggity</h2>
 
   	 	<?php if(isset($_SESSION['logged_in'])) : ?>
		<?php $user = unserialize($_SESSION['user']); ?>
			Hello, <?php echo $user->username; ?>. You are logged in. <a href="logout.php">Logout</a> | <a href="settings.php">Change Email</a>
		<?php else : ?>
			You are not logged in. <a href="login.php">Log In</a> | <a href="register.php">Register</a>
		<?php endif; ?>
 
 	</div>


	</div>	<!--Main container-->

		<!--Import jquery and bootstrap-->
		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<script src="js/bootstrap.js"></script>

</body>
</html>