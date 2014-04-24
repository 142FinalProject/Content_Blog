&lt;?php
//User.class.php

require_once 'DB.class.php';


class User {

	public $id;
	public $username;
	public $hashedPassword;
	public $email;
	public $joinDate;

	//Constructor is called whenever a new object is created.
	//Takes an associative array with the DB row as an argument.
	function __construct($data) {
		$this-&gt;id = (isset($data['id'])) ? $data['id'] : "";
		$this-&gt;username = (isset($data['username'])) ? $data['username'] : "";
		$this-&gt;hashedPassword = (isset($data['password'])) ? $data['password'] : "";
		$this-&gt;email = (isset($data['email'])) ? $data['email'] : "";
		$this-&gt;joinDate = (isset($data['join_date'])) ? $data['join_date'] : "";
	}

	public function save($isNewUser = false) {
		//create a new database object.
		$db = new DB();
		
		//if the user is already registered and we're
		//just updating their info.
		if(!$isNewUser) {
			//set the data array
			$data = array(
				"username" =&gt; "'$this-&gt;username'",
				"password" =&gt; "'$this-&gt;hashedPassword'",
				"email" =&gt; "'$this-&gt;email'"
			);
			
			//update the row in the database
			$db-&gt;update($data, 'users', 'id = '.$this-&gt;id);
		}else {
		//if the user is being registered for the first time.
			$data = array(
				"username" =&gt; "'$this-&gt;username'",
				"password" =&gt; "'$this-&gt;hashedPassword'",
				"email" =&gt; "'$this-&gt;email'",
				"join_date" =&gt; "'".date("Y-m-d H:i:s",time())."'"
			);
			
			$this-&gt;id = $db-&gt;insert($data, 'users');
			$this-&gt;joinDate = time();
		}
		return true;
	}
	
}

?&gt;