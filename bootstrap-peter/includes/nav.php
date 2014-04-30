<div class="navbar">
	<div class="navbar-inner">
		<div class="container">
			<ul class="nav">
				<?php 
				if(basename($_SERVER['PHP_SELF'])=="index.php"){
    				print '<li class="active"><a href="#">Home</a></li>';
				} else {
   				    print '<li><a href="index.php">Home</a></li>';
				} 
				?>

				<?php 
				if(basename($_SERVER['PHP_SELF'])=="post.php"){
    				print '<li class="active"><a href="#">Post</a></li>';
				} else {
   				    print '<li><a href="post.php">Post</a></li>';
				} 
				?>
				</ul>
				<ul class="nav" style="float:right;">
				<?php 
				if(basename($_SERVER['PHP_SELF'])=="login.php"){
    				print '<li class="active"><a href="#">Login</a></li>';
				} else {
    				print '<li><a href="login.php">Login</a></li>';
				} 
				?>   

				<?php 
				if(basename($_SERVER['PHP_SELF'])=="register.php"){
    				print '<li class="active"><a href="#">Register</a></li>';
				} else {
    				print '<li><a href="register.php">Register</a></li>';
				} 
				?> 
			</ul>
		</div>
	</div>
</div>

