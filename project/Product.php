<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
class Product{
//variables	
private $name;
private $surname;
private $prodPrice;
private $prodQuantity;
private $prodDiscount;
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

public function setProductPrice($prodPrice)
{
	$this->prodPrice=$prodPrice;
}

public function setProductDiscount($prodDiscount)
{
 $this->prodDiscount=$prodDiscount;	
}

public function setProductQuantity($prodQuantity)
{
	$this->prodQuantity=$prodQuantity;
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

public function  setProductDescription($prodDescrip)

{
	return $this->prodDescrip;
}

//get functions

public function  getName($name)

{
	return $this->name;
}




public function  getProductCode()

{
	return $this->prodCode;
}


public function  getProductPrice()

{
	return $this->prodPrice;
}

public function  getProductName()

{
	return $this->prodName;
}


public function  getProductQuantity()

{
	return $this->prodQuantity;
}


public function  getSurname()

{
	return $this->surname;
}

public function getProductDiscount()
{
 return $this->prodDiscount;	
}
}
?>
</body>
</html>