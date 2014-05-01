<?php
//UserTools.class.php

require_once 'User.class.php';
require_once 'DB.class.php';

class UserTools {

	//Log the user in. First checks to see if the 
	//username and password match a row in the database.
	//If it is successful, set the session variables
	//and store the user object within.
	public function login($username, $password)
	{

		$hashedPassword = md5($password);
		//echo $hashedPassword . " ";
		//echo $username . " ";
		$result = mysql_query("SELECT * FROM tblUser WHERE username = '$username' AND password = '$hashedPassword'");
		//echo "result: ";
		//echo $result;

		//SELECT * FROM tblUser WHERE username = 'maximus' AND password = '4f7e11633b3f8e44b442d79f35dd540d'

		if(mysql_num_rows($result) == 1)
		{
			$_SESSION["user"] = serialize(new User(mysql_fetch_assoc($result)));
			$_SESSION["login_time"] = time();
			$_SESSION["logged_in"] = 1;
			return true;
		}else{
			return false;
		}
	}
	
	//Log the user out. Destroy the session variables.
	public function logout() {
		unset($_SESSION['user']);
		unset($_SESSION['login_time']);
		unset($_SESSION['logged_in']);
		session_destroy();
	}

	//Check to see if a username exists.
	//This is called during registration to make sure all user names are unique.
	public function checkUsernameExists($username) {
		$result = mysql_query("SELECT * from tblUser where username='$username'");
    	if(mysql_num_rows($result) == 0)
    	{
			return false;
	   	}else{
	   		return true;
		}
	}
	
	//get a user
	//returns a User object. Takes the users id as an input
	public function get($id)
	{
		$db = new DB();
		$result = $db->select('tblUser', "id = $id");
		
		return new User($result);
	}
	
}

?>