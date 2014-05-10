<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php

class Category{
	
	//variables
	private $catName;
	private $catDescription;
	
	//set function
	public function setCategoryName($catName)
	{
		$this->catName=$catName;
	}
	
	public function setCategoryDescription($catDescription)
	{
		$this->catDescription=$catDescription;
	}
	//get functions
	public function getCategoryName()
	{
		return $this->catName;
	}
	
	public function getCategoryDescription()
	{
		return $this->catDescription;
	}
	
}
?>

</body>
</html>