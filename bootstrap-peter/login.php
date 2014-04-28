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
	<h1><a href="#">Blog Diggity!</a></h1>

		<div class="navbar">
			<div class="navbar-inner">
				<div class="container">
				<ul class="nav">
					<li><a href="index.html">Home</a></li>
					<li><a href="#">Post</a></li>
					<li class="active"><a href="#">Account</a></li>
				</ul>
				</div>
			</div>
		</div>	

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