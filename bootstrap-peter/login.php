&lt;?php
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
	if($userTools-&gt;login($username, $password)){
		//successful login, redirect them to a page
		header("Location: index.php");
	}else{
		$error = "Incorrect username or password. Please try again.";
	}
}
?&gt;

&lt;html&gt;
&lt;head&gt;
	&lt;title&gt;Login&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
&lt;?php
if($error != "")
{
    echo $error."&lt;br/&gt;";
}
?&gt;
	&lt;form action="login.php" method="post"&gt;
	    Username: &lt;input type="text" name="username" value="&lt;?php echo $username; ?&gt;" /&gt;&lt;br/&gt;
	    Password: &lt;input type="password" name="password" value="&lt;?php echo $password; ?&gt;" /&gt;&lt;br/&gt;
	    &lt;input type="submit" value="Login" name="submit-login" /&gt;
	&lt;/form&gt;
&lt;/body&gt;
&lt;/html&gt;