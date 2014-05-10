<?php
require "_modules/settings.php";
require_once "_modules/productmanager.php";

$manager = new ProductManager();

session_start();

$pageTitle = "Books Search";
include "_comp/header.php";
?>
 
<!-- Page Content
================================================== -->
<SECTION id=typography>
	<DIV class=page-header>

<H1>Books Search</H1></DIV>
<form action="search.php" method="get" class="form-search">
	<p>Enter a book name, author or price to search for</p>
  <input type="text" name="q" class="input-medium search-query">
  <button type="submit" class="btn">Search</button>
</form>
<H2 id=headings>
<?php if (isset($_GET['q'])) { echo "\"" . $_GET['q'] . "\" search results"; ?></H2>
<?php
$page = 1;
if (isset($_GET['page']))
	$page = $_GET['page'];
$books = $manager->search($_GET['q'], $page);

if (count($books) == 0) {
	print "<p>No books found</p>";
}else{
	$count = 0;
	$limit = 3;
	echo "<tr>";
	foreach($books as $book) {
		if ($count % $limit == 0 && $count != 0) {echo "</tr><tr>";}
?>
<table class="table table-bordered" width="100%" border="0" align="center" style="text-align:center">
	<tr><td style="text-align:center">
    	<a href="product.php?book=<?php echo $book->getId(); ?>"><img src="images/prod_icons/<?php echo $book->getIcon(); ?>" alt="<?php echo $book->getName(); ?>" class="img-rounded" style="background-color: #339966; max-width:200; max-height:200;"/></a>
    </td></tr>
    <tr class="info"><td style="text-align:center">
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
<?php  $count++;
}} } ?>
<p></p>
<?php 
if (isset($_GET['q'])){
if ($page==1 && count($books) > 9) echo "<a href=\"?q=".$_GET['q']."&page=2\" class=\"btn\">Next Page</a> ";
if ($page>1) {echo '<a href="?q='.$_GET['q'].'&page='.($page-1).'" class="btn">Previous Page</a>';
echo '<a href="?q='.$_GET['q'].'&page='.($page+1).'" class="btn">Next Page</a>';}
}
 ?>
</SECTION>

<?php
include "_comp/footer.php";
?>