<?php

require_once 'classes/user.class.php';
require_once 'database.php';
require_once 'clock.php';
require_once 'email.php';

class Account{
    
	//	Handles the registration process
    public function register($username, $email, $country, $pass1, $pass2, $spamFilter, $toc, $cellnum, $postalAddr, $fullname) {
        $errorMessages = "";
        $newUser = new User();
        
        #   Validating and assigning Username
        /*if (empty($username)) {
            $ErrorList["username"] = true;
            $errorMessages .= "Username cannot be empty<br/>";
        }else{
            if (!User::isExistUsername($username)) {
                $response = $newUser->setUsername($username);
                if ($response !== true){
                    $ErrorList["username"] = true;
                    $errorMessages .= $response."<br/>";
                }     
            }else{
                $ErrorList["username"] = true;
                $errorMessages .= "Username already exist in our system, try a different username<br/>";
            }  
        }*/
        #   Validating and assigning Email
        if (empty($email)) {
            $ErrorList["email"] = true;
            $errorMessages .= "Email cannot be empty<br/>";
        }else{
            if (!User::isExistEmail($email)) {
                $response = $newUser->setEmail($email);
                if ($response !== true){
                    $ErrorList["email"] = true;
                    $errorMessages .= $response."<br/>";
                }     
            }else{
                $ErrorList["email"] = true;
                $errorMessages .= "Email already exist in our system, try a different email address<br/>";
            }  
        }
        #   Validating and assigning Country 
        if (empty($country)) {
            $ErrorList["country"] = true;
            $errorMessages .= "Please select your country<br/>";
        }else{
            $response = $newUser->setCountry($country);
            if ($response !== true){
                $ErrorList["country"] = true;
                $errorMessages .= $response."<br/>";
            }     
        }
        #   Validating and assigning Password 1
        if (empty($pass1)) {
            $ErrorList["pass1"] = true;
            $errorMessages .= "Please enter your password<br/>";
        }else{
            $response = $newUser->setPassword($pass1);
            if ($response !== true){
                $ErrorList["pass1"] = true;
                $errorMessages .= $response."<br/>";
            }
        }
        #   Validating password 2
        if (empty($pass2)) {
            $ErrorList["pass2"] = true;
            $errorMessages .= "Please re-enter you password<br/>";
        }else{
            if ($pass1 != $pass2) {
                $ErrorList["pass2"] = true;
                $errorMessages .= "Both Passwords must match<br/>";
            }
        }
        #   Validationg the spam filter
        if (empty($spamFilter)) {
            $ErrorList["sec_code"] = true;
            $errorMessages .= "Please enter the spam filter code<br/>";
        }else{
            if ($_SESSION['ckey'] != md5($spamFilter)) {
                $ErrorList["sec_code"] = true;
                $errorMessages .= "Spam filter code incorrect, Please enter the code as it is in the image<br/>";
            }
        }
		
        if (empty($cellnum)) {
            $ErrorList["cellnum"] = true;
            $errorMessages .= "Please enter your cellnum<br/>";
        }else{
            $response = $newUser->setCellnum($cellnum);
            if ($response !== true){
                $ErrorList["cellnum"] = true;
                $errorMessages .= $response."<br/>";
            }
        }
        
		if (empty($postalAddr)) {
            $ErrorList["postalAddr"] = true;
            $errorMessages .= "Please enter your postalAddr<br/>";
        }else{
            $response = $newUser->setPostalAddr($postalAddr);
            if ($response !== true){
                $ErrorList["postalAddr"] = true;
                $errorMessages .= $response."<br/>";
            }
        }
        
		if (empty($fullname)) {
            $ErrorList["fullname"] = true;
            $errorMessages .= "Please enter your fullname<br/>";
        }else{
            $response = $newUser->setFullname($fullname);
            if ($response !== true){
                $ErrorList["fullname"] = true;
                $errorMessages .= $response."<br/>";
            }
        }
        
		
        if ($toc != "true") {
            $ErrorList["toc"] = true;
            $errorMessages .= "You have to agree to SMG terms and conditions of use<br/>";
        }
        
        #   No errors continue processing
        if ($errorMessages == "") {
            if ($newUser->saveUser()) {
				$act_code = User::getActivationCode($email);
				$act_link = "http://localhost/register.php?activate&email=$email&code=$act_code";
				$message = "
Thank you for creating an account with at ". SITE_NAME ."\n\n
Username: $username \n
Password: $pass1 \n
Activation Code: $act_code \n
____________________________________________
*** ACTIVATION LINK ***** \n
Activation Link: $act_link \n\n
_____________________________________________
Thank you. This is an automated response. PLEASE DO NOT REPLY.				
";
				$mailer = new Email();
				$mailer->sendMail($email, "Social Music Guru - Activation", $message);
				header("Location: register.php?activate");
				exit;
			}else{
				return "Internal processing error occured, try again and if problem persist contact administrator";
			}
        }else{
            return $errorMessages;
        }
        
    }
	
	//	Handles account activation process
	public function activate($email, $code) {
		Database::connect();
		$errorMessage = "";
		if (empty($email) || empty($code)) {
			$errorMessage = "Please fill all the fields below";
		}
		else if (strlen($email) > 255 || strlen($code) > 50) {
			$errorMessage = "Unacceptable email or code length";
		}else if (!User::isExistEmail($email)) {
			$errorMessage = "Your email \"$email\" does not exist in our system, You can register for an SMG free acount";
		}else if (User::getActivationCode($email) != $code) {
			$errorMessage = "Invalid activation code";
		}else{
			if (User::activate_user($email)) {
				$mailer = new Email();
				$mailer->sendMail($email, "Social Music Guru - Account activation", "Thank you for activation your account\n\nYou can now start exploring SMG, enjoy...");
				header("Location: login.php");
				exit;
			}else{
				$errorMessage = "Internal processing error, please try again or contact administrator if problem persist";	
			}
		}
		return $errorMessage;
	}
	
	//	Handles Login process
	public function login($username_email, $password) {
		Database::connect();
		if (strlen($username_email) > 255 || strlen($password) > 50)
			return "Unacceptable username, email or password length";
		$username_email = trim($username_email);
		$password = trim($password);
		$error = User::login($username_email, $password);
		if ($error == "admin") {
			header("Location: admin_dashboard.php");
			exit;
		}else if ($error == "customer") {
			header("Location: dashboard.php");
			exit;
		}else{
			return $error;
		}		
	}
	
	//Admin functions
	
	public function listCustomers($page) {
		if (!is_numeric($page)) {
			echo "Sorry, cannot load customers at the moment (System says: Incorrect page reference)";
			$page = 0;
		}
		$maxPagePosts = 10;
		$start = (($maxPagePosts*$page)-$maxPagePosts);
		$end = $maxPagePosts*$page;	
		$query = "SELECT `username` FROM `users` WHERE `is_admin`=0 Limit $start, $end";
		$result = Database::executeRealQuery($query);
		$customers = array();
		while($row = $result->fetch_assoc()) {
			array_push($customers, new User($row['username']));
		}
		return $customers;
	}
	
	public function countCustomers() {
		$query = "SELECT `username` FROM `users` WHERE `is_admin`=0";
		$result = Database::executeRealQuery($query);
		return $result->num_rows;
	}
	
	public function forceActivate($username, $activate=true) {
		$username = Database::clean($username);
		$query = "";
		if ($activate)
			$query = "UPDATE `users` SET `is_active`=1 WHERE `username`='$username'";
		else
			$query = "UPDATE `users` SET `is_active`=0 WHERE `username`='$username'";
		Database::executeNonQuery($query);
	}
	
	public function forceBan($username, $ban=true) {
		$username = Database::clean($username);
		$query = "";
		if ($ban)
			$query = "UPDATE `users` SET `is_ban`=1 WHERE `username`='$username'";
		else
			$query = "UPDATE `users` SET `is_ban`=0 WHERE `username`='$username'";
		Database::executeNonQuery($query);
	}
	
	public function forceDelete($username) {
		$username = Database::clean($username);
		$query = "DELETE FROM `users` WHERE `username`='$username'";
		Database::executeNonQuery($query);
	}
	
	public function listAdmins($page) {
		if (!is_numeric($page)) {
			echo "Sorry, cannot load customers at the moment (System says: Incorrect page reference)";
			$page = 0;
		}
		$maxPagePosts = 10;
		$start = (($maxPagePosts*$page)-$maxPagePosts);
		$end = $maxPagePosts*$page;	
		$query = "SELECT `username` FROM `users` WHERE `is_admin`=1 Limit $start, $end";
		$result = Database::executeRealQuery($query);
		$customers = array();
		while($row = $result->fetch_assoc()) {
			array_push($customers, new User($row['username']));
		}
		return $customers;
	}
	
	public function countAdmins() {
		$query = "SELECT `username` FROM `users` WHERE `is_admin`=1";
		$result = Database::executeRealQuery($query);
		return $result->num_rows;
	}
	
	public function makeAdmin($username) {
		$username = Database::clean($username);	
		$myUser = new User($username);
		return $myUser->make_admin();
	}
	
	public function revokeAdmin($username) {
		$username = Database::clean($username);	
		$myUser = new User($username);
		return $myUser->revoke_admin();
	}
	
	public function mailCustomers($subject, $body) {
		$query = "SELECT `username` FROM `users` WHERE `is_admin`=0";
		$result = Database::executeRealQuery($query);
		$customers = array();
		while($row = $result->fetch_assoc()) {
			array_push($customers, new User($row['username']));
		}
		$to = "";
		$current = new User($_SESSION['user']);
		foreach ($customers as $customer) {
			$to .= $customer->getFullname()."<".$customer->getEmail().">, ";
		}
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		$headers .= 'From: '.$current->getFullname().' <'.$current->getEmail().'>' . "\r\n";

		$to .= $current->getFullname() ."<".$current->getEmail().">";
		return mail($to, $subject, $body, $headers);
	}

    
}

?>