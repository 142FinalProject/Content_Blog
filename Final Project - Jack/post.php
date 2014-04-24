<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="generator" content="CoffeeCup HTML Editor (www.coffeecup.com)">
    <meta name="dcterms.created" content="Mon, 21 Apr 2014 22:08:43 GMT">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>Post</title>
    
    <!--[if IE]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
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
  </body>
</html>