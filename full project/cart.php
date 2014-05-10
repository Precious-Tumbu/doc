<?php
require "_modules/settings.php";
require_once "_modules/productmanager.php";

session_start();

$manager = new ProductManager();
$msg = "";


if (!isset($_SESSION['user'])) {
	//Temp Cart functions
	# Add a book to cart
	if (isset($_GET['additem'])) {
		if (!is_numeric($_GET['additem'])) {
			$msg = "Invalid book selected";
		}
		else if ($manager->tempCartCheck($_GET['additem'])) {
			$msg = "book already added to cart";
		}else{
			$manager->tempCartAdd($_GET['additem']);
			$msg = "Book added to cart";
		}
		$msg =  urlencode($msg);
		header("Location: cart.php?resp=$msg");
		exit;
	}
	
	# remove a book from cart
	if (isset($_GET['removeitem'])) {
		if (!is_numeric($_GET['removeitem'])) {
			$msg = "Invalid book selected";
		}
		else if (!$manager->tempCartCheck($_GET['removeitem'])) {
			$msg = "book not yet added to cart";
		}else{
			$manager->tempCartRemove($_GET['removeitem']);
			$msg = "Book Removed from cart";
		}
		$msg =  urlencode($msg);
		header("Location: cart.php?resp=$msg");
		exit;
	}
	
	#clear cart
	if (isset($_GET['clearAll'])) {
		$manager->tempCartClear();
		$msg = "Cart Cleared";
		header("Location: cart.php?resp=$msg");
		exit;
	}
}else{
	//Permenent Cart functions
	# Carts Auto Syncronization
	if (isset($_SESSION['cart'])) {
		foreach($_SESSION['cart'] as $tempItem) {
			if (!$manager->permCartCheck($tempItem))
				$manager->permCartAdd($tempItem);	
		}
		unset($_SESSION['cart']);
		$msg = "Carts Auto-Sync: Syncronisation successful";	
	}
	# Add a book to cart
	if (isset($_GET['additem'])) {
		if (!is_numeric($_GET['additem'])) {
			$msg = "Invalid book selected";
		}
		else if ($manager->permCartCheck($_GET['additem'])) {
			$msg = "book already added to cart";
		}else{
			$manager->permCartAdd($_GET['additem']);
			$msg = "Book added to cart";
		}
		$msg =  urlencode($msg);
		header("Location: cart.php?resp=$msg");
		exit;
	}
	
	# remove a book from cart
	if (isset($_GET['removeitem'])) {
		if (!is_numeric($_GET['removeitem'])) {
			$msg = "Invalid book selected";
		}
		else if (!$manager->permCartCheck($_GET['removeitem'])) {
			$msg = "book not yet added to cart";
		}else{
			$manager->permCartRemove($_GET['removeitem']);
			$msg = "Book Removed from cart";
		}
		$msg =  urlencode($msg);
		header("Location: cart.php?resp=$msg");
		exit;
	}
	
	#clear cart
	if (isset($_GET['clearAll'])) {
		$manager->permCartClear();
		$msg = "Cart Cleared";
		header("Location: cart.php?resp=$msg");
		exit;
	}
}

if (isset($_GET['resp']))
	$msg = $_GET['resp'];


$pageTitle = "Your Shopping Cart";
include "_comp/header.php";

?>
 
<!-- Page Content
================================================== -->
<SECTION id=typography>
	<DIV class=page-header>
    
    
<p>
<?php if ($msg != "" ) { ?>
<div class="alert alert-block alert-warning fade in">
<button type="button" class="close" data-dismiss="alert">×</button>
<p><?php echo $msg; ?></p>
</div>
<?php } ?>
</p>


<H1>Your Shopping Cart</H1></DIV>
<p>
</p>
<table class="table table-bordered" width="100%" border="0">
<?php
if (!isset($_SESSION['user'])) {
	$books = $manager->tempCartView();
}else{
	$books = $manager->permCartView();
}
if (count($books) > 0) {
	$count = 0;
	$limit = 3;
	echo "<tr>";
	foreach($books as $book) {
		if ($count % $limit == 0 && $count != 0) {echo "</tr><tr>";}
	?>

		<td>
			<p><a href="product.php?book=<?php echo $book->getId(); ?>"><img src="images/prod_icons/<?php echo $book->getIcon(); ?>" alt="<?php echo $book->getName(); ?>" style="background-color: #339966; max-width:200; max-height:200;" /></a></p>
			<p><a href="product.php?book=<?php echo $book->getId(); ?>"><h3><?php echo $book->getName(); ?></h3></a></p>
			<p>Author: <?php echo $book->getAuthor(); ?></p>
			<p>Price: <?php echo $book->getPrice(); ?></p>
			<p><a href="cart.php?removeitem=<?php echo $book->getId(); ?>" role="button" class="btn btn-warning">Remove from cart</a></p>
		</td>
	
	<?php
	 $count++;
} echo "</tr>";
}else{
	echo '<tr><td>You have no book(s) in your shopping cart</td></tr>';	
	
}
?>
</table>

<table class="table table-bordered" width="100%" border="0">
  <tr class="info">
    <td style="text-align:center;"><?php if (!isset($_SESSION['user']))echo $manager->tempCartTotalBooks();else	echo $manager->permCartTotalBooks(); ?> Total Books in Cart<br/>
    Total Amount Due: R <?php if (!isset($_SESSION['user']))echo $manager->tempCartTotalPrice();else	echo $manager->permCartTotalPrice(); ?>
    </td>
  </tr>
  <tr class="warning">
    <td style="text-align:center;">
    <i class="icon-shopping-cart"></i><a href="transaction.php">Checkout books in cart</a><br/>
    <i class="icon-remove"></i><a href="cart.php?clearAll">Remove all books in cart</a>
    </td>
  </tr>
</table>
<p></p>
</SECTION>

<?php
include "_comp/footer.php";
?>