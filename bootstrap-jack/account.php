<?php
//index.php 

require_once 'includes/global.inc.php';
?>

<html>
<head>
	<title>Account</title>
	<link rel="stylesheet" href="css/bootstrap.css"  type="text/css">

</head>
<body>
	<!--This is the bootstrap framework for our site, subject to change, obvioiusly.  replace hrefs leading to "#" with their actual targets as we build them"-->

	<div class="container">
	<!-- <h1><a href="index.php">Blog Diggity!</a></h1> -->
        

	<?php
	if(isset($_SESSION['logged_in'])){
		include 'includes/nav-in.php'; 
	} else {
		include 'includes/nav.php';
	}
	?>
	
	<div class="hero-unit">
    	<h2>   	 	<?php if(isset($_SESSION['logged_in'])) : ?>
		<?php $user = unserialize($_SESSION['user']); ?>
            <h2>Account</h2>
            
            <p><a href="settings.php">Change Email</a></p>
            <?php endif; ?>

		
 
 	</div>

 	<div class="span4">
 				
 		
 		<div class="posted">
                    <h4>Your Posts:</h4>	
		<!--This is where posts are formatted to be displayed, populate variables with sql queries-->

		<?php
			// $name='username';
			// $link='http://url.com';
			// $title='Look at this link I found today!';


			$dbName="BMCOMBER_CS142Final";        
			$admin_username = "bmcomber_admin";
			$admin_password = "ourDB142";
			$dsn = 'mysql:host=webdb.uvm.edu;dbname=';

			function dbConnect($dbName){
    			global $datab, $dsn, $admin_username, $admin_password;

    			// create the PDO object
    			if (!$datab) $datab = new PDO($dsn . $dbName, $admin_username, $admin_password); 
        			if (!$datab) {
          				return 0;
        			} else {
          				return $datab;
        			}
			} 

			try {     
    			$datab=dbConnect($dbName);
    			//echo '<p>You are connected to the database!</p>';
			} catch (PDOException $e) {
    			$error_message = $e->getMessage();
    			//echo "<p>A An error occurred while connecting to the database: $error_message </p>";
			}

	  		mysql_connect("webdb.uvm.edu", $admin_username, $admin_password);
	  		mysql_select_db("BMCOMBER_CS142Final");
      		$res = mysql_query("SELECT * FROM tblPost WHERE userID='$user->id'");
	  		
	  		print("<div class='span6'>");
	  		print("<table class='table table-striped'>");
      		while($row=mysql_fetch_array($res)){
      			print("<tr>");
 				print("<td>");
	  			print("<h6>Posted on " . $row["date"] . ":</h6>");
         		$result = substr($row["link"], 0, 4);
         		if ($result == "http"){
					print("<h4><a href='" . $row["link"] . "'>" . $row["title"] . "</a></h4>");
					print("</tr>");
					print("</td>");
         		}else{
         			print("<h4><a href='http://" . $row["link"] . "'>" . $row["title"] . "</a></h4>");
         			print("</tr>");
					print("</td>");
         		}
	  		}
	  		print("</table>");
	  		print("</div>");
		?>

 		</div>

 	</div>

	</div>	<!--Main container-->

		<!--Import jquery and bootstrap-->
		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<script src="js/bootstrap.js"></script>

</body>
</html>