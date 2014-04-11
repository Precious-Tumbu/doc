<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
class Admin{
	
//variables
private $name;
private $surname;
private $userName;
private $password;
private $retypPassworrd;


//set functions
public function setName($name)
{
	$this->name=$name;
}

public function setSurName($surname)
{
	$this->surname=$surname;
}


public function setUsername($username)
{
	$this->username=$username;
}

public function setPassword($password)
{
	$this->password=$password;
}

public function setRetypePassword($retypPassword)
{
	$this->retypPassword=$retypPassword;
}

//get function
public function  getName()

{
	return $this->name;
}

public function  getPassword()

{
	return $this->password;
}


public function  getSurname()

{
	return $this->surname;
}



public function  getUsername()

{
	return $this->username;
}

public function  getRetypePassword()

{
	return $this->retypPassword;
}
}
?>
</body>
</html>