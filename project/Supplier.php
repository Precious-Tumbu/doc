<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body><?php
class Supplier{


//variables	
private $name;
private $surname;
private $company;
private $phone;

private $prodName;
private $prodCode;
private $prodDescrip;



//set functions
public function setName($name)
{
	$this->name=$name;
}

public function setSurName($surname)
{
	$this->surname=$surname;
}

public function setCompany($company)
{
	$this->company=$company;
}

public function setPhone($phone)
{
	$this->phone=$phone;
}

public function setProductName($prodName)
{
	$this->prodName=$prodName;
}

public function setProductCode($prodCode)
{
	$this->prodCode=$prodCode;
}


public function setProductDescription($prodDescrip)
{
	$this->prodDescrip=$prodDescrip;
}

//get functions
public function  getName()

{
	return $this->name;
}

public function  setProductDescription()

{
	return $this->prodDescrip;
}


public function  getProductCode()

{
	return $this->prodCode;
}


public function  getCompany()

{
	return $this->company;
}

public function  getProductName()

{
	return $this->prodName;
}


public function  getPhone()

{
	return $this->phone;
}


public function  getSurname()

{
	return $this->surname;
}


}
?>

</body>
</html>