<?php
require "../_modules/settings.php";
require_once "../_modules/productmanager.php";
require_once "../_modules/account.php";

session_start();

if (isset($_SESSION['user'])) {
	if ($_SESSION['isAdmin'] !== true) {
		header("Location: login.php");
		exit;	
	}	
}


$manager = new ProductManager();
$account = new Account();
$msg = "";


if (isset($_GET['id'])) {
$category = $manager->viewCategory($_GET['id']);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Category</title>
</head>

<body>
<form action="editCategory.php" method="post">
	<input type="hidden" name="action" value="editCategory" />
    <label for="addcategory">Category name</label><br/>
    <input type="hidden" name="action" value="edit" />
    <input type="hidden" name="id" value="<?php echo $category->getId(); ?>" />
    <input id="addcategory" type="text" name="name" value="<?php echo $category->getName(); ?>" /><br/>
    <label for="descCat">Category description</label><br/>
    <textarea id="descCat" name="desc" rows="3"><?php echo $category->getDesc(); ?></textarea>
  	<br/>
    <button type="submit">Edit Category</button>
</form>


</body>
</html>
<?php }
else if (isset($_POST['action'])) {
	if (!$manager->editCategory($_POST['id'], $_POST['name'], $_POST['desc'])){
		echo '<p style="color:red">Unable to update category</p><br/><a href="javascript:history.back(1)">Back</a>';
	}else{
?>		
	<script type="text/javascript">
    	window.opener.location = "../admin_dashboard.php";
		window.close();
    </script>
<?php }}

?>