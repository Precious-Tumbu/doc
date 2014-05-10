<?php
require "_modules/settings.php";
require_once "_modules/productmanager.php";

session_start();

$manager = new ProductManager();

$pageTitle = "Books Catalogue";
include "_comp/header.php";
?>
 
<!-- Page Content
================================================== -->
<SECTION id=typography>
<H2>Books Catalogue</H2>
<table class="table" width="100%" border="0">
<?php
if (isset($_GET['category'])){
# view books by category
$cat_id = $_GET['category'];

$page = 1;
if (isset($_GET['page']))
	$page = $_GET['page'];

if (!is_numeric($cat_id)) {
	header("Location: error.php?fatalError=Invalid+category");
	exit;	
}
$books = $manager->getBooksByCategory($cat_id, $page);
$category = $manager->viewCategory($cat_id);
echo "<h3><em>".$category->getName()."</em></h3>";
if (count($books) == 0) {
	print "<tr><td>No books available in this categories<br/><br/><br/><br/><br/><br/><br/><br/></td></tr>";
}else{
	$count = 0;
	$limit = 3;
	echo "<tr>";
	foreach($books as $book) {
		if ($count % $limit == 0 && $count != 0) {echo "</tr><tr>";}
?>
<td>
<table class="table table-bordered" width="100%" border="0">
	<tr ><td>
    	<a href="product.php?book=<?php echo $book->getId(); ?>"><img src="images/prod_icons/<?php echo $book->getIcon(); ?>" alt="<?php echo $book->getName(); ?>" class="img-rounded" style="background-color: #339966; max-width:200; max-height:200;"/></a>
    </td></tr>
    <tr class="info"><td>
    	<p><a href="product.php?book=<?php echo $book->getId(); ?>"><h3><?php echo $book->getName(); ?></h3></a></p>
        <p>by <?php echo $book->getAuthor(); ?></p>
        <p>R <?php echo $book->getPrice(); ?></p>
        <p><?php 
		if (!isset($_SESSION['user'])) {
		 if (!$manager->tempCartCheck($book->getId()))
				echo '<a href="cart.php?additem='.$book->getId().'" role="button" class="btn btn-success">Add to cart</a>';
			else
				echo '<a href="cart.php?removeitem='.$book->getId().'" role="button" class="btn btn-warning">Remove from cart</a>';
		}else{
			if (!$manager->permCartCheck($book->getId()))
				echo '<a href="cart.php?additem='.$book->getId().'" role="button" class="btn btn-success">Add to cart</a>';
			else
				echo '<a href="cart.php?removeitem='.$book->getId().'" role="button" class="btn btn-warning">Remove from cart</a>';
		}		
        ?></p>
    </td></tr>
</table>
</td>
<?php  $count++;
} echo "</tr>";
}
}else{
# Views category list
$categories = $manager->getCategoryList();
if (count($categories) == 0){
	print "<tr><td>No Categories available</td></tr>";
}else{
	$count = 0;
	$limit = 3;
	echo "<tr>";
	
	foreach($categories as $category) {
		
		if ($count % $limit == 0 && $count != 0) {echo "</tr><tr>";}
?>
<td>
<table class="table table-bordered" width="100%" border="0">
	<tr ><td>
    	<a href="catalogue.php?category=<?php echo $category->getId(); ?>"><img src="images/category.jpg" alt="<?php echo $category->getName(); ?>" class="img-rounded" style="background-color: #339966; max-width:200; max-height:200;"/></a>
    </td></tr>
    <tr class="info"><td>
    	<p><a href="catalogue.php?category=<?php echo $category->getId(); ?>"><h3><?php echo $category->getName() . ' ('. $manager->getTotalProductsPerCategory($category->getId()) . ')'; ?></h3></a></p>
        <p><?php echo $category->getDesc(); ?></p>
    </td></tr>
</table>
</td>
<?php
 $count++;
} echo "</tr>";
}
$page = 1;
if (isset($_GET['page']))
	$page = $_GET['page'];
/*if ($page==1 && count($categories) > 9) echo "<a href=\"?page=2\" class=\"btn\">Next Page</a> ";
if ($page>1) {echo '<a href="?page='.($page-1).'" class="btn">Previous Page</a>';
echo '<a href="?page='.($page+1).'" class="btn">Next Page</a>';}*/
}
?>
</table>
<?php if (isset($_GET['category'])) {
if ($page==1 && count($categories) > 9) echo "<a href=\"?category=".$_GET['category']."&page=2\" class=\"btn\">Next Page</a> ";
if ($page>1) {echo '<a href="?category='.$_GET['category'].'&page='.($page-1).'" class="btn">Previous Page</a>';
echo '<a href="?category='.$_GET['category'].'&page='.($page+1).'" class="btn">Next Page</a>';}
}
 ?>
<p></p>
</SECTION>

<?php
include "_comp/footer.php";
?>