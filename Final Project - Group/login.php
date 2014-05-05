<?php
//login.php

require_once 'includes/global.inc.php';

$error = "";
$username = "";
$password = "";

//check to see if they've submitted the login form
if(isset($_POST['submit-login'])) { 

	$username = $_POST['username'];
	$password = $_POST['password'];

	$userTools = new UserTools();
	if($userTools->login($username, $password)){
		//successful login, redirect them to a page
		header("Location: index.php");
	}else{
		$error = "Incorrect username or password. Please try again.";
	}
}
?>

<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="css/bootstrap.css"  type="text/css">
</head>
<body>
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
    	<h2>Please Log In</h2>

 		<?php
			if($error != "")
			{
    			echo $error."<br/>";
			}
		?>

		<form action="login.php" method="post">
	    	Username: <input type="text" name="username" value="<?php echo $username; ?>" /><br/>
	    	Password: <input type="password" name="password" value="<?php echo $password; ?>" /><br/>
	    	<input type="submit" value="Login" name="submit-login" />
		</form>
   	 	
 	</div>
	</div>	<!--Main container-->

</body>
</html>