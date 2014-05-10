<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
class Order{
//variables	
private $ordernum;
private $amtDue;
private $prodPrice;
private $prodQuantity;
private $prodDiscount;
private $orderDate;
private $prodName;



//set functions
public function setOrderNumber($ordernum)
{
	$this->ordernum=$ordernum;
}

public function setAmountDue($amtDue)
{
	$this->amtDue=$amtDue;
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

public function setOrderDate($orderDate)
{
	$this->orderDate=$orderDate;
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

public function  getOrderNumber($ordernum)

{
	return $this->ordernum;
}




public function  getAmountDue()

{
	return $this->amtDue;
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


public function  getOrderDate()

{
	return $this->orderDate;
}

public function getProductDiscount()
{
 return $this->prodDiscount;	
}
}
?>
</body>
</html>