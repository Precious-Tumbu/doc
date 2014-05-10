<?php
require "_modules/settings.php";
require_once "_modules/productmanager.php";
require_once "_modules/account.php";

session_start();

if (isset($_SESSION['user'])) {
	if ($_SESSION['isAdmin'] !== true) {
		header("Location: login.php");
		exit;	
	}	
}else{
	header("Location: login.php");
	exit;	
}


$manager = new ProductManager();
$account = new Account();
$msg = "";

if (isset($_GET['UserActivate']))
	$account->forceActivate($_GET['UserActivate'], true);
if (isset($_GET['UserDeactivate']))
	$account->forceActivate($_GET['UserDeactivate'], false);
if (isset($_GET['UserBan']))
	$account->forceBan($_GET['UserBan'], true);
if (isset($_GET['UserUnban']))
	$account->forceBan($_GET['UserUnban'], false);
if (isset($_GET['UserDelete']))
	$account->forceDelete($_GET['UserDelete']);

if (isset($_GET['make_admin'])) {
	//Chack if user is super admin
	if ($_SESSION['user'] == "admin@firstserve.co.za") {
		$account->makeAdmin($_GET['make_admin']);
	}else{
		header("Location: error.php?fatalError=Only+super+admin+account+can+perform+this+action");
		exit;	
	}
}
if (isset($_GET['revoke_admin'])) {
	//Chack if user is super admin
	//deny super admin from revoking own admin rights
	if ($_SESSION['user'] == "admin@firstserve.co.za") {
		if ($_GET['revoke_admin'] != "admin@firstserve.co.za" || $_GET['revoke_admin']!=$_SESSION['user']) {
			$account->revokeAdmin($_GET['revoke_admin']);
		}else{
			header("Location: error.php?fatalError=Cannot+revoke+own+administration+previledges");
			exit;
		}
	}else{
		header("Location: error.php?fatalError=Only+super+admin+account+can+perform+this+action");
		exit;	
	}
	
}
if (isset($_GET['UserUnban']) || isset($_GET['UserDeactivate']) || isset($_GET['UserActivate']) || isset($_GET['UserBan']) || isset($_GET['UserDelete']) || isset($_GET['make_admin']) || isset($_GET['make_admin'])){
	header("Location: admin_dashboard.php");
	exit;
}
	
if (isset($_POST['action'])) {
	if ($_POST['action'] == "addProduct") {
		
		if (empty($_POST['name']))
			$msg = "Book name cannot be empty";
		if (empty($_POST['price']))
			$msg = "Book price cannot be empty";
		if (empty($_POST['isbn']))
			$msg = "Book isbn cannot be empty";
		if (empty($_POST['author']))
			$msg = "Book author cannot be empty";
		if (empty($_POST['theme']))
			$msg = "Book theme cannot be empty";
		if (empty($_POST['release']))
			$msg = "Book release cannot be empty";
		if ($_POST['category'] == 0)
			$msg = "You cannot add a book into no category<br/>Add atleast one category first and then add a book";
			
		if ($msg == "") {
			
			$icon = rand(100,10000) . basename($_FILES['icon']['name']);
			$bookfile = rand(100,10000) . basename($_FILES['book']['name']);
			
			if ($manager->addProduct($_POST['name'], $_POST['category'], $_POST['price'], $_POST['isbn'], $_POST['author'], $_POST['theme'], $bookfile, $icon, $_POST['release'])) {
				//save uploaded icon image
				$uploaddir = 'images/prod_icons/';
				$uploadfile = $uploaddir . $icon;
				
				if (!move_uploaded_file($_FILES['icon']['tmp_name'], $uploadfile)) {
					$msg =  "Failed to upload Icon Image";
				}
				//save uploaded book file
				$uploaddir = '_data/books/';
				$uploadfile = $uploaddir . $bookfile;
				
				if (!move_uploaded_file($_FILES['book']['tmp_name'], $uploadfile)) {
					$msg =  "Failed to upload Book Image";
				}
				$msg = "Book added successfully";
			}else{
				$msg = "Failed to add Book";
			}
		}
	}
	if ($_POST['action'] == "deleteCategory") {
		if ($manager->deleteCategory($_POST['category']))
			$msg = "Category deleted";
		else
			$msg = "Failed to delete category";
	}
	if ($_POST['action'] == "addCategory") {
		if ($manager->addCategory($_POST['name'], $_POST['desc']))
			$msg = "Category added";
		else
			$msg = "Failed to add category";
	}
}

if (isset($_POST['mail'])) {
	if (empty($_POST['subject']))
		$msg = "Subject cannot be empty";
	else if (empty($_POST['body']))
		$msg = "E-mail Body cannot be empty";
	else{
		if ($account->mailCustomers($_POST['subject'], $_POST['body']))
			$msg = "Emails sent successfully";
		else
			$msg = "Failed to send emails";
	}
}


$pageTitle = "Admin Dashboard";
include "_comp/header.php";
?>
 


<?php
include "_comp/footer.php";
?>