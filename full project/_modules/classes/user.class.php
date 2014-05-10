<?php
/**	This class represents a single instance of a user account
*	Requires Database class and Clock class
*/

//require_once "../database.php";
//require_once "../clock.php";

class User {
	
	private $username;
	private $email;
	private $password;
	private $country;
	private $act_code;
	private $is_active;
	private $is_ban;
	private $is_admin;
	private $validation;
	private $date_created;
	private $date_lastlogin;
	private $cellnum;
	private $postalAddr;
	private $fullname;
	
	
	// Constructor prepares to create a new user account or loads user data if username provided
	public function __construct($username = "new") {
		### Conect to database if not connected
		if (!Database::status()) {
			Database::connect();
		}
		### Checks if username is given in the parameter
		if ($username != "new") {
			$username = Database::clean($username);
			$this->username = $username;
			$query = "SELECT * FROM `users` WHERE `username`='$username'";
			$result = Database::executeRealQuery($query);
			### If username does not exists result in a fatal error and output the error
			if (!$result) {
				if (!headers_sent())
					header("Location: error.php?fatalError=".Database::$link->error);
				else
					echo "<p>Internal error - ".Database::$link->error."</p>";
				exit;
			}
			### Fetch the fields from the database
			while ($row = $result->fetch_assoc()) {
				$this->email = $row['email'];
				$this->password = $row['password'];
				$this->country = $row['country'];
				$this->act_code = $row['act_code'];
				$this->is_active = $row['is_active'];
				$this->is_admin = $row['is_admin'];
				$this->is_ban = $row['is_ban'];
				$this->validation = $row['validation'];
				$this->date_created = new Clock($row['date_created']);
				$this->date_lastlogin = new Clock($row['date_lastlogin']);
				$this->fullname = $row['fullname'];
				$this->cellnum = $row['cellnum'];
				$this->postalAddr = $row['postalAddr'];
			}
		}else{
			#initialize system variables
			$this->act_code = rand(1000,99999);
			$this->is_active = 0;
			$this->is_admin = 0;
			$this->is_ban = 0;
			$this->date_created = new Clock();
			$this->date_lastlogin = new Clock();
		}
	
	}
	
	//static functions
	public static function isExistUsername($username) {
		$username = Database::clean($username);
		$query = "SELECT `username` FROM `users` WHERE `username`='$username'";
		$result = Database::executeRealQuery($query);
		if ($result->num_rows == 0)
			return false;
		else
			return true;
	}
	
	public static function isExistEmail($email) {
		$email = Database::clean($email);
		$query = "SELECT `email` FROM `users` WHERE `email`='$email'";
		$result = Database::executeRealQuery($query);
		if ($result->num_rows == 0)
			return false;
		else
			return true;
	}
	
	public static function getActivationCode($email) {
		$email = Database::clean($email);
		$query = "SELECT `act_code` FROM `users` WHERE `email`='$email'";
		$result = Database::executeRealQuery($query);
		if (!$result)
			return false;
		while ($row = $result->fetch_assoc()) {
			return $row['act_code'];
		}
	}
	
	public static function activate_user($email) {
		$email = Database::clean($email);
		$query = "UPDATE `users` SET `is_active`=1 WHERE `email`='$email'";
		$result = Database::executeNonQuery($query);
		if (!$result)
			return false;
		else
			return true;
	}
	
	public static function login($username_email, $password) {
		//	!!! IMPORTANT !!!
		//	Requires Sessions to be initialized using session_start() call;
		//	Requires a redirect after successful execution;
		$username_email = Database::clean($username_email);
		$password = Database::clean($password);
		$password = md5($password);
		$query = "SELECT `username` FROM `users` WHERE (`username`='$username_email' OR `email`='$username_email') AND `password`='$password'";
		$result = Database::executeRealQuery($query);
		if ($result->num_rows > 0) {
			//authenticate user
			$user;
			while($row = $result->fetch_assoc()) {
				$user = $row['username'];
			}
			
			$myUser = new User($user);
			if ($myUser->getIsBan())
				return "Your account has been banned by the administrator";
			if (!$myUser->getIsActive())
				return "Your account is not yet activated, please activate your account first";
			$_SESSION['user'] = $user;
			$_SESSION['isAdmin'] = $myUser->getIsAdmin();
			if ($myUser->getIsAdmin())
				return "admin";
			else
				return "customer";
		}else{
			return "Invalid username, email or password";	
		}
	}
	
	public function make_admin() {
		$this->setIsAdmin(true);
		$this->setIsActive(true);
		$this->validation = md5($this->username . $this->is_admin . $this->date_created->getDateBasic());
		$query = "
				UPDATE `users` SET `is_admin`=$this->is_admin,`is_active`=$this->is_active, `validation`='$this->validation' WHERE `username`='$this->username'
			";
		$result = Database::executeNonQuery($query);
		return $result;
	}
	
	public function revoke_admin() {
		$this->setIsAdmin(false);
		$this->setIsActive(true);
		$this->validation = md5($this->username . $this->is_admin . $this->date_created->getDateBasic());
		$query = "
				UPDATE `users` SET `is_admin`=$this->is_admin,`is_active`=$this->is_active, `validation`='$this->validation' WHERE `username`='$this->username'
			";
		$result = Database::executeNonQuery($query);
		return $result;
	}
	
	public function validate() {
		if ($this->validation == md5($this->username . $this->is_admin . $this->date_created->getDateBasic()))
			return true;
		else
			return false;
	}
	
	// It is the responsibility of the account class to ensure that all values required have been set before calling this function
	// The function also assumes that username and email provided do not exist in the system
	public function saveUser() {
		if (!User::isExistUsername($this->username)) {
			$this->username = $this->email;
			if ($this->username == "admin@firstserve.co.za") {
				//Reserve "admin@firstserve.co.za" as super admin
				$this->is_admin = 1;
				$this->is_active = 1;	
			}
			$this->validation = md5($this->username . $this->is_admin . $this->date_created->getDateBasic());
			$query = "
				INSERT INTO `users`
			(`username`,`password`,`email`,`country`,`act_code`,`is_ban`,`is_active`,`is_admin`,`validation`,`date_created`,`date_lastlogin`, `fullname`, `cellnum`, `postalAddr`)
				VALUES
				('$this->username','$this->password','$this->email', '$this->country', $this->act_code, $this->is_ban, $this->is_active, $this->is_admin,'$this->validation','".$this->date_created->getDateBasic()."','".$this->date_lastlogin->getDateBasic()."', '$this->fullname', '$this->cellnum', '$this->postalAddr')
			";
			$result = Database::executeNonQuery($query);
			return $result;
		}else{
			$query = "
				UPDATE `users` SET
			(`password`,`email`,`country`,`act_code`,`is_ban`,`is_active`, `fullname`, `cellnum`, `postalAddr`)
				VALUES
				('$this->password','$this->email', '$this->country', $this->act_code, $this->is_ban, $this->is_active, '$this->fullname', '$this->cellnum', '$this->postalAddr')
				WHERE `username`='$this->username'
			";
			$result = Database::executeNonQuery($query);
			return $result;
		}
	}
	
	//Setters
	public function setUsername($username) {
		$username = strtolower($username);
		if (!preg_match("/^[a-z0-9_\.\-]{5,50}/", $username))
			return "Username must be between 5 and 50 characters in length, contains alphanumeric characters and only a dot, underscore or desh as special characters";
		$this->username = $username;
		return true;
	}
	
	public function setEmail($email) {
		$email = strtolower($email);
		if (!preg_match("/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+\.[a-zA-Z0-9_\.-]+$/", $email))
			return "Email must be in a correct email format and must be a valid email address as it will be used to activate your account";
		$this->email = $email;
		return true;
	}
	
	public function setPassword($password) {
		$password = trim($password);
		if (strlen($password) < 5 || strlen($password) > 25)
			return "Password must be between 5 and 25 characters in length";
		$this->password = md5($password);
		return true;
	}
	
	public function setCountry($country) {
		$country = trim($country);
		$country = strip_tags($country);
		$country = Database::clean($country);
		if (strlen($country) < 1 || strlen($country) > 50)
			return "Invalid country length";
		$this->country = $country;
                return true;
	}
	public function setFullname($fullname) {
		$fullname = trim($fullname);
		$fullname = strip_tags($fullname);
		$fullname = Database::clean($fullname);
		if (strlen($fullname) < 1 || strlen($fullname) > 50)
			return "Invalid name length";
		$this->fullname = $fullname;
                return true;
	}
	public function setCellnum($cellnum) {
		$cellnum = trim($cellnum);
		$cellnum = strip_tags($cellnum);
		$cellnum = Database::clean($cellnum);
		if (strlen($cellnum) < 1 || strlen($cellnum) > 50)
			return "Invalid cell number";
		$this->cellnum = $cellnum;
                return true;
	}
	public function setPostalAddr($postalAddr) {
		$postalAddr = trim($postalAddr);
		$postalAddr = strip_tags($postalAddr);
		$postalAddr = Database::clean($postalAddr);
		if (strlen($postalAddr) < 1 || strlen($postalAddr) > 50)
			return "Invalid postal address length";
		$this->postalAddr = $postalAddr;
                return true;
	}
	
	public function setActCode() {
		$this->act_code = rand(1000,99999);
		return $this->act_code;
	}
	
	public function setIsBan($ban) {
		if ($ban)
			$this->is_ban = 1;
		else
			$this->is_ban = 0;
		return true;
	}
	
	public function setIsActive($active) {
		if ($active)
			$this->is_active = 1;
		else
			$this->is_active = 0;
		return true;
	}
	
	public function setIsAdmin($admin) {
		if ($admin)
			$this->is_admin = 1;
		else
			$this->is_admin = 0;
		return true;
	}
	
	//getters
	public function getUsername() {
		return $this->username;
	}
	
	public function getFullname() {
		return $this->fullname;
	}
	public function getCellnum() {
		return $this->cellnum;
	}
	public function getPostalAddr() {
		return $this->postalAddr;
	}
	
	public function getEmail() {
		return $this->email;
	}
	
	public function getPassword() {
		return $this->password;	
	}
	
	public function getCountry() {
		return $this->country;
	}
	
	public function getIsAdmin() {
		if ($this->is_admin == 1)
			return true;
		else
			return false;
	}
	
	public function getIsBan() {
		if ($this->is_ban == 1)
			return true;
		else
			return false;
	}
	
	public function getIsActive() {
		if ($this->is_active == 1)
			return true;
		else
			return false;
	}
	
	public function getActCode() {
		return $this->act_code;
	}
	
	public function getDateCreated() {
		return $this->date_created->getDateAdvanced();
	}
	
	public function getDateLastLogin() {
		return $this->date_lastlogin->getDateAdvanced();
	}

}

?>