<?php
require "_modules/settings.php";
require_once "_modules/productmanager.php";

session_start();

$pageTitle = "Unexpected Error!";
include "_comp/header.php";
?>

<!-- Page Content
================================================== -->
<SECTION id=typography>
	<DIV class=page-header>
<?php if (isset($_GET['fatalError'])) {
	echo "<p>Error details: ".$_GET['fatalError']."</p>"; 
	}else{
	echo "There system provided no additional information on this error!";
}		
	?>
<p>If problem persist please contact administrator</p>
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