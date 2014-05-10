<?php
require_once "_modules/settings.php";
require_once "_modules/productmanager.php";

session_start();

if (isset($_SESSION['user'])) {
	if ($_SESSION['isAdmin'] === true) {
		header("Location: admin_dashboard.php");
		exit;	
	}else{
		header("Location: dashboard.php");
		exit;	
	}
}

$pageTitle = "The ultimate litrature library";
include "_comp/header.php";
?>
 
<!-- Page Content
================================================== -->
<SECTION id=typography>
	<DIV class=page-header>

<H1>Top Books in the shop</H1></DIV>
<p>
</p>
<?php
	//Attempt to display 9 most purchased products/books
	$manager = new ProductManager();
	$books = $manager->getCatalogueTop();
	
	if (count($books) == 0) { ?>
		<table class="table table-bordered" width="100%" border="0">
        <tr class="success">
        <td style="text-align:center">There is currently no available book in store</td></tr>
        </table>
<?php }else { 
	$itemsCount = 0;
	$printedLabels = 0;
	$tableRows = 1;
	$tableCols = 1;
	echo '<table class="table table-bordered" width="100%" border="0"><tr>';
	for ($i=0; $i<count($books);$i++) {
		$book = $books[$i];
		echo '<td><a href="product.php?book='.$book->getId().'"><img class="img-rounded" name="'.$book->getName().'" src="images/prod_icons/'.$book->getIcon().'" width="200" height="200" alt="'.$book->getName().'" style="background-color: #339966; max-width:200; max-height:200;"></a></td>';
		if ($tableCols == 4) {
			$tableCols = 1;
			$tableRows++;
			echo '</tr><tr class="success">';
			for ($x=$i-3;$x<$i;$x++) {
				$book = $books[$x];
				echo '<td><b><a href="product.php?book='.$book->getId().'">'.$book->getName().'</a></b><br/>'.$book->getAuthor().'<br/>R '.$book->getPrice().'<br/>';
			if (!$manager->tempCartCheck($book->getId()))
				echo '<a href="index.php?additem='.$book->getId().'">Add to cart</a></td>';
			else
				echo '<a href="index.php?removeitem='.$book->getId().'">Remove from cart</a></td>';
			
			$printedLabels++;
			}
			echo '</tr><tr>';
		}
		$itemsCount++;
		if ($i == count($books)-1) {
			echo '</tr><tr class="success">';
			for ($x=($tableRows*3-3);$x<count($books);$x++) {
				$book = $books[$x];
				echo '<td><b><a href="product.php?book='.$book->getId().'">'.$book->getName().'</a></b><br/>'.$book->getAuthor().'<br/>R '.$book->getPrice().'<br/>';
				if (!$manager->tempCartCheck($book->getId()))
				echo '<a href="index.php?additem='.$book->getId().'">Add to cart</a></td>';
			else
				echo '<a href="index.php?removeitem='.$book->getId().'">Remove from cart</a></td>';
			}
			echo '</tr><tr>';
		}		
	}
	echo '</tr></table>';
 }

?>
<p></p>
</SECTION>

<?php
include "_comp/footer.php";
?>