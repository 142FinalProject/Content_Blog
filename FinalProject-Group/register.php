<?php
//register.php

require_once 'includes/global.inc.php';

//initialize php variables used in the form
$username = "";
$password = "";
$password_confirm = "";
$email = "";
$error = "";

//check to see that the form has been submitted
if(isset($_POST['submit-form'])) { 

	//retrieve the $_POST variables
	$username = $_POST['username'];
	$password = $_POST['password'];
	$password_confirm = $_POST['password-confirm'];
	$email = $_POST['email'];

	//initialize variables for form validation
	$success = true;
	$userTools = new UserTools();

	//validate that the form was filled out correctly
	//check to see if user name already exists
	if($userTools->checkUsernameExists($username))
	{
	    $error .= "That username is already taken.<br/> \n\r";
	    $success = false;
            
	}

	//check to see if passwords match
	if($password != $password_confirm) {
	    $error .= "Passwords do not match.<br/> \n\r";
	    $success = false;
	}
        
	if($success)
	{
	    //prep the data for saving in a new user object
	    $data['username'] = $username;
	    $data['password'] = md5($password); //encrypt the password for storage
	    $data['email'] = $email;

	    //create the new user object
	    $newUser = new User($data);

	    //save the new user to the database
	    $newUser->save(true);

	    //log them in
	    $userTools->login($username, $password);

	    //redirect them to a welcome page
	    header("Location: welcome.php");
            
	}

}

//If the form wasn't submitted, or didn't validate
//then we show the registration form again
?>

<html>
<head>
	<title>Registration</title>
	<link rel="stylesheet" href="css/bootstrap.css"  type="text/css">
	<link rel="shortcut icon" href="http://www.uvm.edu/~jtbrenna/cs142/Final%20Project/FinalProject-Group/favicon.ico">
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
    	<h2>Register</h2>

		<?php echo ($error != "") ? $error : ""; ?>

		<form action="register.php" method="post">

			Username: <input type="text" value="<?php echo $username; ?>" name="username" /><br/>
			Password: <input type="password" value="<?php echo $password; ?>" name="password" /><br/>
			Password (confirm): <input type="password" value="<?php echo $password_confirm; ?>" name="password-confirm" /><br/>
			E-Mail: <input type="text" value="<?php echo $email; ?>" name="email" /><br/>
			<input type="submit" value="Register" name="submit-form" />

		</form>
 	</div>

	</div>	<!--Main container-->

		<!--Import jquery and bootstrap-->
		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<script src="js/bootstrap.js"></script>

</body>
<div id="image"><a href="mailto:bmcomber@uvm.edu?Subject=Ad%20Space" target="_top"><img src="http://www.uvm.edu/~bmcomber/cs142/assignment7/Content_Blog/FinalProject-Group/img/YourAdHere.png" alt="Your Ad Here"></a></div>
<?PHP include('includes/footer.php');?>
</html>