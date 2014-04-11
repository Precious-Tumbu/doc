<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
class Bill{
	
	//varaiables
	
	private $bildate;
	private $address;
	
	//set functions
	 public function  setDate($bildate)
     {

	   $this->bildate=$bildate;
	 }
	 
   public function  setAddress($address)
   {
	   $this->address=$address; 
   }


	

	//set functions
	public function  getAddress()
    {

	 return $this->address;
	}
	
	public function  getDate()
    {

	 return $this->bildate;
	}

}



?>
</body>
</html>