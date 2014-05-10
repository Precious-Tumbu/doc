<?php
require "_modules/settings.php";
require_once "_modules/productmanager.php";

session_start();
if (!isset($_SESSION['user'])) {
	header("Location: login.php");
	exit;	
}

$manager = new ProductManager();
$downloads = $manager->listDownloads();

$pageTitle = "Dashboard";
include "_comp/header.php";
?>

<!-- Page Content
================================================== -->
<SECTION id=typography>
	<DIV class=page-header>

<h1>Welcome - Dashboard</h1>
<hr/>
<?php
if (empty($downloads))
	echo "No Downloads available for you. Purchase books to get their download link.";
$count = 0;
foreach($downloads as $download) {
	echo "<h6>Book $count</h6>";
	echo "<p>Transaction Id: ".$download->getTransId()."</p>";
	echo "<p>Downloads left: ".$download->getNumber()."</p>";
	echo "<p>Purchase date: ".$download->getDate()."</p>";
	echo "<p><a href=\"download.php?code=".$download->getCode()."\">Download Book</a></p>";
	echo "<hr/>";
	$count++;
}
?>
<br/><br />
<br />
<br />
<br />
<br />
<br />



</SECTION>

<?php
include "_comp/footer.php";
?>