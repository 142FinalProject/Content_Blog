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
	<h1><a href="index.php">Blog Diggity!</a></h1>

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

 	<div class="span4">
 				
 		
 		<div class="posted">
 			
		<!--This is where posts are formatted to be displayed, populate variables with sql queries-->

		<?php
			$name='username';
			$link='http://url.com';
			$title='Look at this link I found today!';


			print("<h6>" . $name . " posted:</h6>");
        $result = substr($link, 0, 4);
        if ($result == "http"){
			print("<h4><a href='" . $link . "'>" . $title . "</a></h4>");
        }else{
        	print("<h4><a href='http://" . $link . "'>" . $title . "</a></h4>");
        }
		?>

 		</div>

 	</div>

	</div>	<!--Main container-->

		<!--Import jquery and bootstrap-->
		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<script src="js/bootstrap.js"></script>

</body>
</html>