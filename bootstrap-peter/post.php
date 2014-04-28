<html>
<head>
	<title>Post</title>
	<link rel="stylesheet" href="css/bootstrap.css"  type="text/css">
</head>
<?php 
$urlPath = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");
$name = "";
$link = "";
$title = "";

if (isset($_POST["btnSubmit"])){
    // Sanatize data coming from form
    
    $name = htmlentities($_POST["fname"],ENT_QUOTES,"UTF-8");
	  $title = htmlentities($_POST["title"],ENT_QUOTES,"UTF-8");
    $link = htmlentities($_POST["link"],ENT_QUOTES,"UTF-8");
    $result = "";
                      
}
?>
<body>
	<!--This is the bootstrap framework for our site, subject to change, obvioiusly.  replace hrefs leading to "#" with their actual targets as we build them"-->

	<div class="container">
	<h1><a href="#">Blog Diggity!</a></h1>

	<?php include 'includes/nav.php'; ?>
	
	<div class="hero-unit">
    	<h2>Welcome to blog Diggity</h2>
 
   	 	<?php include('connect.php'); ?>
  		<h1>Post Something</h1>
		<?php include('nav.php'); ?>
		
		<form action="<? print $urlPath; ?>" method="post">
  			  Name: <input type="text" name="fname"><br>
			    Title: <input type="text" name="title"><br>
  			  Link: <input type="text" name="link" size="75"><br>
  			  <input type="submit" name="btnSubmit" value="Submit" method="post" action="">
		</form>
		
		<?php
		if (isset($_POST["btnSubmit"])){
			print("<h6>" . $name . " posted:</h6>");
        $result = substr($link, 0, 4);
        if ($result == "http"){
			print("<h3><a href='" . $link . "'>" . $title . "</a></h3>");
        }else{
        	print("<h3><a href='http://" . $link . "'>" . $title . "</a></h3>");
        }
		}
		?>
 
 	</div>
	</div>	<!--Main container-->

		<!--Import jquery and bootstrap-->
		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<script src="js/bootstrap.js"></script>

</body>
</html>