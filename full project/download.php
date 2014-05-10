<?php
require "_modules/settings.php";
require_once "_modules/productmanager.php";

session_start();
if (!isset($_SESSION['user'])) {
	header("Location: login.php");
	exit;	
}

$manager = new ProductManager();

if (isset($_GET['code'])) {
	$file = $manager->download($_GET['code']);
	if ($file!="") {
		header('Content-type: application/pdf');
		header('Content-Disposition: attachment; filename="downloaded.pdf"');
		readfile("_data/books/$file");
		exit;
	}
}

$pageTitle = "Download";
include "_comp/header.php";
?>

<!-- Page Content
================================================== -->
<SECTION id=typography>
	<DIV class=page-header>

<h1>Unable to Download book</h1>
<p>Invalid or no book may have been specified</p>
<p>Download link may have expired</p>
<br/><br />
<br />
<br />
<br />
<br />
<br />
<br/>
<br/>
<br/>
<br/>
<br/>



</SECTION>

<?php
include "_comp/footer.php";
?>