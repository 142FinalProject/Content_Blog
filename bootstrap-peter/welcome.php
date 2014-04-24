&lt;?php
//welcome.php

require_once 'includes/global.inc.php';

//check to see if they're logged in
if(!isset($_SESSION['logged_in'])) {
	header("Location: login.php");
}

//get the user object from the session
$user = unserialize($_SESSION['user']);

?&gt;

&lt;html&gt;
&lt;head&gt;
	&lt;title&gt;Welcome &lt;?php echo $user-&gt;username; ?&gt;&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
	Hey there, &lt;?php echo $user-&gt;username; ?&gt;. You've been registered and logged in. Welcome! &lt;a href="logout.php"&gt;Log Out&lt;/a&gt; | &lt;a href="index.php"&gt;Return to Homepage&lt;/a&gt;
&lt;/body&gt;
&lt;/html&gt;