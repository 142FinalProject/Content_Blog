<?php
//User.class.php

require_once 'DB.class.php';

class Post {
	public $id;
	public $username;
	public $title;
	public $link;

	//Constructor is called whenever a new object is created.
	//Takes an associative array with the DB row as an argument.
	function __construct($data) {
		$this->id = (isset($data['postID'])) ? $data['postID'] : "";
        $this->username = (isset($data['username'])) ? $data['username'] : "";
		$this->title = (isset($data['title'])) ? $data['title'] : "";
		$this->link = (isset($data['link'])) ? $data['link'] : "";
	}

	public function save() {
		//create a new database object.
		$db = new DB();
		
		$data = array(
			"postID" => "'$this->postID'",
			"username" => "'$this->username'",
			"title" => "'$this->title'",
			"link" => "'$this->link'"
		);
			
		$this->id = $db->insert($data, 'tblUser');
	}
}
?>