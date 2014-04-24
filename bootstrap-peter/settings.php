&lt;?php 

require_once 'includes/global.inc.php';

//check to see if they're logged in
if(!isset($_SESSION['logged_in'])) {
	header("Location: login.php");
}

//get the user object from the session
$user = unserialize($_SESSION['user']);

//initialize php variables used in the form
$email = $user-&gt;email;
$message = "";

//check to see that the form has been submitted
if(isset($_POST['submit-settings'])) { 

	//retrieve the $_POST variables
	$email = $_POST['email'];

	$user-&gt;email = $email;
	$user-&gt;save();

	$message = "Settings Saved&lt;br/&gt;";
}

//If the form wasn't submitted, or didn't validate
//then we show the registration form again
?&gt;

&lt;html&gt;
&lt;head&gt;
	&lt;title&gt;Change Settings&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
	&lt;?php echo $message; ?&gt;

	&lt;form action="settings.php" method="post"&gt;

	E-Mail: &lt;input type="text" value="&lt;?php echo $email; ?&gt;" name="email" /&gt;&lt;br/&gt;
	&lt;input type="submit" value="Update" name="submit-settings" /&gt;

	&lt;/form&gt;
&lt;/body&gt;
&lt;/html&gt;