<?php 
//post.php

require_once 'includes/global.inc.php';
?>

<html>
<head>
	<title>Post</title>
	<link rel="stylesheet" href="css/bootstrap.css"  type="text/css">
	<link rel="shortcut icon" href="favicon.ico">
</head>
<body>
	<!--This is the bootstrap framework for our site, subject to change, obvioiusly.  replace hrefs leading to "#" with their actual targets as we build them"-->

	<div class="container">
	<!-- <h1><a href="#">Blog Diggity!</a></h1> -->

	<?php
	if(isset($_SESSION['logged_in'])){
		include 'includes/nav-in.php'; 
	} else {
		include 'includes/nav.php';
	}
	?>
	
	<div class="hero-unit">
 
  		<h2>Post Something</h2>

  		<?php if(isset($_SESSION['logged_in'])) : ?>
		<?php $user = unserialize($_SESSION['user']); ?>
		<?php endif; ?>

  		<?php

		$dbName="BMCOMBER_CS142Final";        
		$admin_username = "bmcomber_admin";
		$admin_password = "ourDB142";
		$dsn = 'mysql:host=webdb.uvm.edu;dbname=';

		function dbConnect($dbName){
    		global $datab, $dsn, $admin_username, $admin_password;

    		if (!$datab) $datab = new PDO($dsn . $dbName, $admin_username, $admin_password); 
        		if (!$datab) {
          			return 0;
        		} else {
          			return $datab;
        		}
		} 

		// create the PDO object
		try {     
    		$datab=dbConnect($dbName);
		} catch (PDOException $e) {
    		$error_message = $e->getMessage();
		}

		//initialize php variables used in the form
		$userID = $user->id;
		$username = $user->username;
		$title = "";
		$link = "";

		//check to see that the form has been submitted
		if(isset($_POST['btnSubmit'])) { 

			//retrieve the $_POST variables
			$title = $_POST['title'];
			$link = $_POST['link'];
			$date = date("m.d.y");

			try { 
		
		    	$sql = "INSERT INTO `BMCOMBER_CS142Final`.`tblPost` (`postID`, `userID`, `username`, `title`, `link`, `date`) VALUES (NULL, '$userID', '$username', '$title', '$link', '$date')";
		    	
            	$stmt = $datab->prepare($sql);
        		echo $sql;
            	$stmt->execute(); 
	
            	$primaryKey = $datab->lastInsertId(); 

            	// all sql statements are done so lets commit to our changes 

        	} catch (PDOExecption $e) { 
            	$datab->rollback(); 
        	}

        	//redirect them to the home page
	    	header("Location: index.php");
		}

		//If the form wasn't submitted, or didn't validate
		//then we show the registration form again

		$user = unserialize($_SESSION['user']);

		$urlPath = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");
		

		if(isset($_SESSION['logged_in'])){

			print "<form action='post.php' method='post'>
				Title: <input type='text' name='title' placeholder='Title to be displayed'><br>
  				URL: <input type='text' name='link' size='75' placeholder='Please include the full URL'><br>
  				<input type='submit' name='btnSubmit' value='Submit'>
			</form>";

		} else {
			print 'You are not logged in. <a href="login.php">Log In</a> | <a href="register.php">Register</a>';
		}
 		?>

 	</div>
	</div>	<!--Main container-->

		<!--Import jquery and bootstrap-->
		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<script src="js/bootstrap.js"></script>
                <div id="image"><a href="mailto:bmcomber@uvm.edu?Subject=Ad%20Space" target="_top"><img src="http://www.uvm.edu/~bmcomber/cs142/assignment7/Content_Blog/FinalProject-Group/img/YourAdHere.png" alt="Your Ad Here"></a></div>
<?PHP include('includes/footer.php');?>
</body>
</html>