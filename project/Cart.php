<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php

class Cart{
	
	//variable
	private $numOfProd;
	
	private $totalPrice;
	
	//set functions
	
	public function setNumbeOfProduct($numOfProd)
	{
		$this->numOfProd=$numOfProd;
	}
	
	public function setTotalPrice($totalPrice)
	{
		$this->totalPrice=$totalPrice;
	}
	//get functions
	public function gettNumbeOfProduct()
	{
		return $this->numOfProd;
	}
	
	public function getTotalPrice()
	{
		return $this->totalPrice;
	}
	
}
?>
</body>
</html>