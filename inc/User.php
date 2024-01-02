<?php 
include_once 'Session.php';
include 'Database.php';

class User {
	private $db;
	public function __construct(){
		$this->db = new Database();
	}

	public function userRegistration($data){
		$name 		= $data['name'];
		$username 	= $data['username'];
		$email 		= $data['email'];
		$password 	= $data['password'];

		$chkemail	= $this->emailCheck($email);

		if ($name=="" OR $username== "" OR $email=="" OR $password=="") {
			$msg = "<div class='alert alert-danger'>Field Must Not Empty</div>";
			return $msg;
		}
		if (strlen($username) < 3) {
			$msg = "<div class='alert alert-danger'>User name is too short please user must up to 3 latter</div>";
			return $msg;
		}elseif(preg_match('/[^a-z0-9_-]+/i', $username)){
			$msg = "<div class='alert alert-danger'>User name must alphanumerical dashed and underscores!</div>";
			return $msg;
		}
		if(strlen($password) < 6){
			$msg = "<div class='alert alert-danger'>Password Must 6 or more latter</div>";
			return $msg;
		}
		if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
		   $msg = "<div class='alert alert-danger'>Invalid Email Address</div>";
			return $msg;
		}
		if ($chkemail == true) {
			$msg = "<div class='alert alert-danger'>Email Allready exist</div>";
			return $msg;
		}

		$password 	= md5($data['password']);
		$sql = "INSERT INTO tbl_user (name, username, email, password) VALUE(:name, :username, :email, :password)";
		$query = $this->db->pdo->prepare($sql);
		$query->bindValue(':name', $name);
		$query->bindValue(':username', $username);
		$query->bindValue(':email', $email);
		$query->bindValue(':password', $password);
		$result = $query->execute();
		if ($result) {
			$msg = "<div class='alert alert-success'>Registration Successfull</div>";
			return $msg;
		}else {
			$msg = "<div class='alert alert-danger'>Registration Faield</div>";
			return $msg;
		}
	}

	public function emailCheck($email){
		$sql = "SELECT email FROM tbl_user WHERE email= :email";
		$query = $this->db->pdo->prepare($sql);
		$query->bindValue(':email', $email);
		$query->execute();
		if ($query->rowCount() > 0) {
			return true;
		}else{
			return false;
		}
	}

	public function getloginUser($email, $password){
		$sql = "SELECT * FROM tbl_user WHERE email= :email AND password = :password Limit 1";
		$query = $this->db->pdo->prepare($sql);
		$query->bindValue(':email', $email);
		$query->bindValue(':password', $password);
		$query->execute();
		$result = $query->fetch(PDO::FETCH_OBJ);
		return $result;
	}

	public function userLogin($data){
		$email 		= $data['email'];
		$password 	= md5($data['password']);
		$chkemail	= $this->emailCheck($email);

		if ($email=="" OR $password=="") {
			$msg = "<div class='alert alert-danger'>Field Must Not Empty</div>";
			return $msg;
		}
		if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
		   $msg = "<div class='alert alert-danger'>Invalid Email Address</div>";
			return $msg;
		}
		if ($chkemail == false) {
			$msg = "<div class='alert alert-danger'>Email not exist</div>";
			return $msg;
		}
		$result = $this->getloginUser($email, $password);
		if ($result) {
			Session::init();
			Session::set("login", true);
			Session::set("id", $result->id);
			Session::set("name", $result->name);
			Session::set("username", $result->username);
			Session::set("loginmsg", "<div class='alert alert-success'>You are logged in</div>");
			header("Location: index.php");
		}else {
			$msg = "<div class='alert alert-danger'>Data not found</div>";
			return $msg;
		}
	}

	public function getUserData(){
		$sql = "SELECT * FROM tbl_user ORDER BY id DESC";
		$query = $this->db->pdo->prepare($sql);
		$query->execute();
		$result = $query->fetchAll();
		return $result;
	}

	public function getUserById($id){
		$sql = "SELECT * FROM tbl_user WHERE id= :id LIMIT 1";
		$query = $this->db->pdo->prepare($sql);
		$query->bindValue(":id", $id);
		$query->execute();
		$result = $query->fetch(PDO::FETCH_OBJ);
		return $result;
	}


	public function updateUserData($id, $data){
		$name 		= $data['name'];
		$username 	= $data['username'];
		$email 		= $data['email'];

		if ($name=="" OR $username== "" OR $email=="") {
			$msg = "<div class='alert alert-danger'>Field Must Not Empty</div>";
			return $msg;
		}

		$sql = "UPDATE tbl_user set 
		name 		= :name,
		username 	= :username,
		email 		= :email
		WHERE id 	= :id";

		$query = $this->db->pdo->prepare($sql);
		$query->bindValue(':name', $name);
		$query->bindValue(':username', $username);
		$query->bindValue(':email', $email);
		$query->bindValue(':id', $id);
		$result = $query->execute();
		if ($result) {
			$msg = "<div class='alert alert-success'>User Data Update successfully</div>";
			return $msg;
		}else {
			$msg = "<div class='alert alert-danger'>User Data Update Faield</div>";
			return $msg;
		}
	}

	public function checkPassword($id, $old_pass){
		$password = md5($old_pass);
		$sql = "SELECT password FROM tbl_user WHERE id= :id AND password=:password";
		$query = $this->db->pdo->prepare($sql);
		$query->bindValue(':id', $id);
		$query->bindValue(':password', $password);
		$query->execute();
		if ($query->rowCount() > 0) {
			return true;
		}else{
			return false;
		}
	}

	public function updatePassword($id, $data){
		$old_pass = $data['old_pass'];
		$new_pass = $data['password'];
		$chk_pass = $this->checkPassword($id, $old_pass);

		if ($old_pass=="" OR $new_pass== "") {
			$msg = "<div class='alert alert-danger'>Field Must Not Empty</div>";
			return $msg;
		}
		if ($chk_pass == false) {
			$msg = "<div class='alert alert-danger'>Old Password Not Exist</div>";
			return $msg;
		}
		if (strlen($new_pass) < 6) {
			$msg = "<div class='alert alert-danger'>Password Too Short</div>";
			return $msg;
		}

		$password = md5($new_pass);
		$sql = "UPDATE tbl_user set 
		password 	= :password
		WHERE id 	= :id";

		$query = $this->db->pdo->prepare($sql);
		$query->bindValue(':password', $password);
		$query->bindValue(':id', $id);
		$result = $query->execute();
		if ($result) {
			$msg = "<div class='alert alert-success'>Password Update successfully</div>";
			return $msg;
		}else {
			$msg = "<div class='alert alert-danger'>Password Update Faield</div>";
			return $msg;
		}

	}
}