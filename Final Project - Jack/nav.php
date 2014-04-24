<link rel="stylesheet" href="navStyle.css" type="text/css" media="screen">

<nav>
     <ul>
<?php 
if(basename($_SERVER['PHP_SELF'])=="main.php"){
    print '<li class="activePage">Home</li>';
} else {
    print '<a href="main.php"><li>Home</li></a>';
} 
?>

<?php 
if(basename($_SERVER['PHP_SELF'])=="post.php"){
    print '<li class="activePage">Post</li>';
} else {
    print '<a href="post.php"><li>Post</li></a>';
} 
?>   
     </ul>
</nav>