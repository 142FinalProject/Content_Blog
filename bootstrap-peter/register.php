&lt;?php
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
	if($userTools-&gt;checkUsernameExists($username))
	{
	    $error .= "That username is already taken.&lt;br/&gt; \n\r";
	    $success = false;
	}

	//check to see if passwords match
	if($password != $password_confirm) {
	    $error .= "Passwords do not match.&lt;br/&gt; \n\r";
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
	    $newUser-&gt;save(true);

	    //log them in
	    $userTools-&gt;login($username, $password);

	    //redirect them to a welcome page
	    header("Location: welcome.php");

	}

}

//If the form wasn't submitted, or didn't validate
//then we show the registration form again
?&gt;

&lt;html&gt;
&lt;head&gt;
	&lt;title&gt;Registration&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
	&lt;?php echo ($error != "") ? $error : ""; ?&gt;
	&lt;form action="register.php" method="post"&gt;

	Username: &lt;input type="text" value="&lt;?php echo $username; ?&gt;" name="username" /&gt;&lt;br/&gt;
	Password: &lt;input type="password" value="&lt;?php echo $password; ?&gt;" name="password" /&gt;&lt;br/&gt;
	Password (confirm): &lt;input type="password" value="&lt;?php echo $password_confirm; ?&gt;" name="password-confirm" /&gt;&lt;br/&gt;
	E-Mail: &lt;input type="text" value="&lt;?php echo $email; ?&gt;" name="email" /&gt;&lt;br/&gt;
	&lt;input type="submit" value="Register" name="submit-form" /&gt;

	&lt;/form&gt;
&lt;/body&gt;
&lt;/html&gt;