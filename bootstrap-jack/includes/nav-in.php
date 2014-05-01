<?php if(isset($_SESSION['logged_in'])) : ?>
<?php $user = unserialize($_SESSION['user']); ?>
<?php endif; ?>
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<ul class="nav">
				<li><h5 style="position:absolute; left:-100%;"><a href="index.php">Blog Diggity!</a></h5></li>
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

                        	if(basename($_SERVER['PHP_SELF'])=="account.php"){
    				print '<li class="active"><a href="#">' . $user->username . '</a></li>';
				} else {
    				print '<li><a href="account.php">' . $user->username . '</a></li>';
				}
				?>
				
				<?php
				if(basename($_SERVER['PHP_SELF'])=="logout.php"){
    				print '<li class="active"><a href="#">Logout</a></li>';
				} else {
    				print '<li><a href="logout.php">Logout</a></li>';
				}
				?> 
			</ul>
		</div>
	</div>
</div>