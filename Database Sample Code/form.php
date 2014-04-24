<?php
// initialize my variables
$debug=false;
$email="";
$message="";
$messageA="";
$messageB="";
$messageC="";
$photoName="";
$bandName="";
$year="";
$genre="";
$upFile="";
$radS = false;
$radH = false;
$list1 = "";
$location = "";
$definition = "";
$yourURL = "https://www.uvm.edu/~jtbrenna/cs148/assignment7.1/form.php";

$debug = false;
require_once("connect.php");

//initialize flags for errors, one for each item
$emailERROR = false;
$photoNameERROR = false;
$bandNameERROR = false;
$yearERROR = false;
$genreERROR = false;

// if form has been submitted, validate the information
if (isset($_POST["butSubmit"])){

    //************************************************************
    // is the refeering web page the one we want or is someone trying 
    // to hack in. this is not 100% reliable */
    $fromPage = getenv("http_referer"); 

    if ($debug) print "<p>From: " . $fromPage . "  should match your Url:  " . $yourURL;

    if($fromPage != $yourURL){
        die("<p>Sorry you cannot access this page. Security breach detected and reported</p>");
    } 
    
    /*
        this function just converts all input to html entites to remove any potentially
        malicious coding
    */
	
    function clean($elem){
        if(!is_array($elem)){
            $elem = htmlentities($elem,ENT_QUOTES,"UTF-8");
        }else{
            foreach ($elem as $key => $value)
                $elem[$key] = clean($value);
		}
        return $elem;
     } 
     
     //check for errors
     include('validation_functions.php');
     $errorMsg=array();
	 
	 // be sure to clean out any code that was submitted
     if(isset($_POST)) $_CLEAN['POST'] = clean($_POST);

     // begin testing each form element 
     
	 
	 // Test email for empty and valid characters 
	 $email=$_CLEAN['POST']['txtEmail'];      
     if (empty($email)) { 
         $errorMsg[] = "Please enter your Email Address"; 
         $emailERROR = true; 
     } else { 
         $valid = verifyEmail($email); /* test for non-valid  data */ 
         if (!$valid) { 
             $errorMsg[] = "The email address you entered is not valid."; 
             $emailERROR = true; 
         } 
     } 
     // Test album name for empty and valid characters
     $photoName=$_CLEAN['POST']['txtPname'];
     if(empty($photoName)){
        $errorMsg[]="Please enter a name for the album";
        $photoNameERROR = true;
     } else {
        $valid = verifyText ($photoName); /* test for non-valid  data */
        if (!$valid){ 
            $errorMsg[]="Album name must be letters and numbers, spaces, dashes and single quotes only.";
            $photoNameERROR = true;
        }
     }
	 
	 // Test band name for empty and valid characters
	 $bandName=$_CLEAN['POST']['txtBname'];
	 if(empty($bandName)){
        $errorMsg[]="Please enter a name for the band";
        $bandNameERROR = true;
     } else {
        $valid = verifyText ($bandName); /* test for non-valid  data */
        if (!$valid){ 
            $errorMsg[]="Band name must be letters and numbers, spaces, dashes and single quotes only.";
            $bandNameERROR = true;
        }
     }
	 
	 // Test year released for empty and valid characters
	 $year=$_CLEAN['POST']['txtYear'];
	 if(empty($year)){
        $errorMsg[]="Please enter the year the album was released";
        $yearERROR = true;
     } else {
        $valid = verifyNum ($year); /* test for non-valid  data */
        if (!$valid){ 
            $errorMsg[]="Year must be numbers only";
            $yearERROR = true;
        }
     }
	 
	 // Test genre for empty and valid characters
	 $genre=$_CLEAN['POST']['txtGenre'];
	 if(empty($genre)){
        $errorMsg[]="Please enter the genre of music";
        $genreERROR = true;
     }
	
	// set values for items not checked. This makes these values on the form 
    // reset when there is an errror. Also the varaibles can be used in a message.
	
	if(isset($_CLEAN['POST']["txtEmail"])){
            $email = $_CLEAN['POST']["txtEmail"];
    }
	
	if(isset($_CLEAN['POST']["txtGenre"])){
            $genre = $_CLEAN['POST']["txtGenre"];
    }
	
	if(isset($_CLEAN['POST']["lst1"])){
            $location = $_CLEAN['POST']["lst1"];
    }

	if(isset($_CLEAN['POST']["rad"])){
            $definition = $_CLEAN['POST']["rad"];
    }
	
	$radio = $_POST['rad'];  
    if ($radio == "") {          
        $errorMsg[]="Please select a definition.";     
    }
	
	//$upFile = $_CLEAN['FILE']['datafile'];
	//if (empty($upFile)) {
    //    $errorMsg[]="Please select a file to upload.";
    //}
	
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="generator" content="">
    <meta name="dcterms.created" content="Wed, 16 Oct 2013 01:08:49 GMT">
    <meta name="description" content="PhotoRoto Form">
    <meta name="keywords" content="">
    <title>Album Art - Form</title>
    
    <!--[if IE]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<link rel="stylesheet" href="formStyle.css" type="text/css" media="screen">
  </head>
  <body>
  <div class="background">
  <?php 
	 include('header.php');
  	 include('nav.php');
	  
	 if(isset($_POST["butSubmit"]) AND empty($errorMsg)){
		
		$primaryKey = ""; 
        $dataEntered = false;
	    $uploads_dir = "images/photos";

        $tmp_name = $_FILES["datafile"]["tmp_name"];
        $name = $_FILES["datafile"]["name"];
        $destination = $uploads_dir . "/" . $name;
	
        $moved = move_uploaded_file($tmp_name, $destination);
	
        $imgURL = "images/photos/" . $name;
		
		//Insert data into tblPhoto
        try { 
            $db->beginTransaction();
		
		    $sql = "INSERT INTO tblPhoto (fldPhotoName, fldImgURL, fldType, fldDefinition) VALUES ('$photoName', '$imgURL', '$location', '$definition')";
            $stmt = $db->prepare($sql);
            if ($debug) print "<p>sql ". $sql;
        
            $stmt->execute(); 
		
             
            $primaryKey = $db->lastInsertId(); 
            if ($debug) print "<p>pk= " . $primaryKey; 

            // all sql statements are done so lets commit to our changes 
            $dataEntered = $db->commit(); 
            if ($debug) print "<p>transaction complete "; 
        } catch (PDOExecption $e) { 
            $db->rollback(); 
            if ($debug) print "Error!: " . $e->getMessage() . "</br>"; 
            $errorMsg[] = "There was a problem with accpeting your data please contact us directly."; 
        }
		
		//Insert data into tblAlbum
		try { 
            $db->beginTransaction();
		
		    $sqlA = "INSERT INTO tblAlbum (fldBand, fldYear, fldGenre) VALUES ('$bandName', '$year', '$genre')";
            $stmtA = $db->prepare($sqlA);
            if ($debug) print "<p>sql ". $sqlA;
        
            $stmtA->execute(); 
		
             
            $primaryKey = $db->lastInsertId(); 
            if ($debug) print "<p>pk= " . $primaryKey; 

            // all sql statements are done so lets commit to our changes 
            $dataEntered = $db->commit(); 
            if ($debug) print "<p>transaction complete "; 
        } catch (PDOExecption $e) { 
            $db->rollback(); 
            if ($debug) print "Error!: " . $e->getMessage() . "</br>"; 
            $errorMsg[] = "There was a problem with accpeting your data please contact us directly."; 
        }
		
		//Insert data into tblUser
		try { 
            $db->beginTransaction();
		
		    $sqlE = "INSERT INTO tblUser (fldEmail) VALUES ('$email')";
            $stmtE = $db->prepare($sqlE);
            if ($debug) print "<p>sql ". $sqlE;
        
            $stmtE->execute(); 
		
             
            $primaryKey = $db->lastInsertId(); 
            if ($debug) print "<p>pk= " . $primaryKey; 

            // all sql statements are done so lets commit to our changes 
            $dataEntered = $db->commit(); 
            if ($debug) print "<p>transaction complete "; 
        } catch (PDOExecption $e) { 
            $db->rollback(); 
            if ($debug) print "Error!: " . $e->getMessage() . "</br>"; 
            $errorMsg[] = "There was a problem with accpeting your data please contact us directly."; 
        }
		
		//Insert data into tblAlbumPhoto
		try { 
            $db->beginTransaction();
		
		    $sqlX = "INSERT INTO tblAlbumPhoto (fkBand, fkPhotoName) VALUES ('$bandName', '$photoName')";
            $stmtX = $db->prepare($sqlX);
            if ($debug) print "<p>sql ". $sqlX;
        
            $stmtX->execute(); 
		
            $primaryKey = $db->lastInsertId(); 
            if ($debug) print "<p>pk= " . $primaryKey; 

            // all sql statements are done so lets commit to our changes 
            $dataEntered = $db->commit(); 
            if ($debug) print "<p>transaction complete "; 
        } catch (PDOExecption $e) { 
            $db->rollback(); 
            if ($debug) print "Error!: " . $e->getMessage() . "</br>"; 
            $errorMsg[] = "There was a problem with accpeting your data please contact us directly."; 
        }
		
		$messageA = '<h2>Thank you for your upload!</h2>'; 

        $messageB = "<p>Click this link to return to PhotoRoto: "; 
        $messageB .= '<a href="http://www.uvm.edu/~jtbrenna/cs148/assignment7.1/main.php">Home Page</a></p>'; 
        $messageB .= "<p>or copy and paste this url into a web browser: "; 
        $messageB .= "http://www.uvm.edu/~jtbrenna/cs148/assignment7.1/main.php</p>"; 

        $messageC .= "<p><b>Email Address:</b><i>   " . $email . "</i></p>"; 

        // email the form's information 
        if(isset($_CLEAN['POST'])) {
            foreach ($_CLEAN['POST'] as $key => $value){
                    $message .= "<p>" . $key . " = " . $value . "</p>";
            }
        }
		
        $subject = "Thank you for your upload"; 
        include_once('mailMessage.php'); 
        $mailed = sendMail($email, $subject, $messageA . $messageB . $messageC . $message);
		
		print "<h3>Your upload has been processed</h3>";
		
  	 }
  ?>						 

     <form action="<? print $_SERVER['PHP_SELF']; ?>" 
            method="post"
            id="frmRegister"
            enctype="multipart/form-data">
           
<fieldset class="intro">
<legend></legend>
<p>All fields are required</p>

<!-- Error Message -->
<div class="error">
<?php
if($errorMsg){
	echo "<p>Errors:</p>\n";
    echo "<ol>\n";
    foreach($errorMsg as $err){
            echo "<li>" . $err . "</li>\n";
    }
    echo "</ol>\n";
}
?>
</div>

<fieldset class="contact"> 
        
		<label class="required" for="txtEmail">Email </label> 
		<input id ="txtEmail" name="txtEmail" class="element text medium<?php if ($emailERROR) echo ' mistake'; ?>" type="text" maxlength="255" value="<?php echo $email; ?>" placeholder="Enter an email address" onfocus="this.select()"  tabindex="31"/> 

</fieldset> 

<!-- Names -->
<fieldset class="contact">
	
	<!-- Artist Name -->                    
    <label for="txtBname" class="required">Band Name</label>
      <input type="text" id="txtBname" name="txtBname" value="<?php echo $bandName; ?>" 
            tabindex="100" maxlength="25" required placeholder="Enter the band name" 
                <?php if($bandNameERROR) echo 'class="mistake"' ?>
                 onfocus="this.select()">
	
	<!-- Album Name -->                    
    <label for="txtPname" class="required">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Album Name</label>
      <input type="text" id="txtPname" name="txtPname" value="<?php echo $photoName; ?>" 
            tabindex="101" maxlength="25" required placeholder="Enter the album name" 
                <?php if($photoNameERROR) echo 'class="mistake"' ?>
                 onfocus="this.select()">

</fieldset>   

<!-- Year Released/Genre -->
<fieldset class="release">
	<label for="txtYear" class="required">Year Released</label>
      <input type="text" id="txtYear" name="txtYear" value="<?php echo $year; ?>" 
            tabindex="102" maxlength="4" required placeholder="Enter the year released" 
                <?php if($yearERROR) echo 'class="mistake"' ?>
                 onfocus="this.select()">
				 
	<label for="txtGenre" class="required">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Genre</label>
      <input type="text" id="txtGenre" name="txtGenre" value="<?php echo $genre; ?>" 
            tabindex="103" maxlength="25" required placeholder="Enter the genre" 
                <?php if($genreERROR) echo 'class="mistake"' ?>
                 onfocus="this.select()">
</fieldset>                   

<!-- Radio Buttons -->
<fieldset class="radio">
    <legend>Select Photo Definition</legend>
    <label><input type="radio" id="radS" name="rad" value="Standard" tabindex="231" 
            <?php if($definition=="Standard") echo ' checked="checked" ';?>/>Standard</label>
            
    <label><input type="radio" id="radH" name="rad" value="HD" tabindex="234" 
            <?php if($definition=="HD") echo ' checked="checked" ';?>/>HD</label>
</fieldset> 

<!-- Upload -->
<fieldset class="upload">
	<legend>Please select a file:</legend>
	<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
	<input id="datafile" type="file" name="datafile">
</fieldset>  

<!-- Drop List -->
<fieldset class="lists">    
    <legend>File Type</legend>
    <select id="lst1" name="lst1" tabindex="281" size="1">
        <option value="JPEG" <?php if($location=="JPEG") echo ' selected="selected" ';?>>JPEG</option>
        <option value="PNG" <?php if($location=="PNG") echo ' selected="selected" ';?>>PNG</option>
        <option value="BMP" <?php if($location=="BMP") echo ' selected="selected" ';?>>BMP</option>
		<option value="GIF" <?php if($location=="GIF") echo ' selected="selected" ';?>>GIF</option>
		<option value="TIFF" <?php if($location=="TIFF") echo ' selected="selected" ';?>>TIFF</option>
    </select>
</fieldset>

<!-- Buttons -->
<div class="buttons">
    <legend></legend>                
    <input type="submit" id="butSubmit" class="button" name="butSubmit" value="Upload" onclick="reSetForm()" tabindex="991"/>
	<input type="reset" id="butReset" name="butReset" value="Reset Form" tabindex="993" class="button" onclick="reSetForm()"/>
</div>                    
</fieldset>
</form>
<p class="words">The album name is what will be displayed above the photo when it is at the front or when the mouse is hovering over it.
	The name, type, definition, image file path, and a date/time stamp are put into a database when the submit button is clicked.
	The name text field uses veryifyText. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed condimentum, turpis non 
	pretium ornare, nulla ligula semper augue, eget blandit nibh nisi vel quam. Nulla laoreet aliquet felis. Integer a elit sit 
	amet nisi porttitor cursus nec id ligula. Aliquam in tortor tincidunt lacus fermentum viverra ac ut dui. Praesent molestie 
	dictum arcu, a tincidunt velit sagittis sed. Pellentesque accumsan sollicitudin nisl, sed facilisis neque pellentesque in. 
	Etiam interdum ante sed semper eleifend. Vestibulum ullamcorper sapien quis dolor cursus aliquet. Ut id auctor purus. Fusce 
	tempus, ipsum a mattis aliquet, tellus ipsum lobortis velit, vel viverra leo.</p>
</div>	
<div>
<?php include('footer.php'); ?>
</div>
</body>
</html>