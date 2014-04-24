&lt;?php
//index.php 

require_once 'includes/global.inc.php';
?&gt;

&lt;html&gt;
&lt;head&gt;
	&lt;title&gt;Homepage&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;

&lt;?php if(isset($_SESSION['logged_in'])) : ?&gt;
	&lt;?php $user = unserialize($_SESSION['user']); ?&gt;
	Hello, &lt;?php echo $user-&gt;username; ?&gt;. You are logged in. &lt;a href="logout.php"&gt;Logout&lt;/a&gt; | &lt;a href="settings.php"&gt;Change Email&lt;/a&gt;
&lt;?php else : ?&gt;
	You are not logged in. &lt;a href="login.php"&gt;Log In&lt;/a&gt; | &lt;a href="register.php"&gt;Register&lt;/a&gt;
&lt;?php endif; ?&gt;

&lt;/body&gt;
&lt;/html&gt;