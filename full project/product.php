<?php
require "_modules/settings.php";
require_once "_modules/productmanager.php";
session_start();

$manager = new ProductManager();
$msg = "";
$product = "";

if (isset($_GET['delete'])) {
	if ($_SESSION['isAdmin'] !== true) {
		header("Location: error.php?fatalError=You+need+to+be+an+administrator+to+perform+this+action");
		exit;
	}
	if ($manager->deleteProduct($_GET['delete']))
		$msg = "book deleted successfully";
	else
		$msg = "Failed to delete book";	
	header("Location: product.php?msg=$msg");
	exit;
	
} else if (isset($_GET['edit'])) {
	
	$product = $manager->viewProduct($_GET['edit']);
	
	if ($_SESSION['isAdmin'] !== true){
		header("Location: error.php?fatalError=You+need+to+be+an+administrator+to+perform+this+action");
		exit;
	}
	if (isset($_POST['name'])) {
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
			if ($_FILES['icon']['size'] > 0)
				$icon = rand(100,10000) . basename($_FILES['icon']['name']);
			else
				$icon = $product->getIcon();
			if ($_FILES['book']['size'] > 0)
				$bookfile = rand(100,10000) . basename($_FILES['book']['name']);
			else
				$bookfile = $product->getFilename();
			if ($manager->editProduct($product->getId(), $_POST['name'], $_POST['category'], $_POST['price'], $_POST['isbn'], $_POST['author'], $_POST['theme'], $bookfile, $icon, $_POST['release'])) {
				
				if ($_FILES['icon']['size'] > 0) {
					//save uploaded icon image
					$uploaddir = 'images/prod_icons/';
					$uploadfile = $uploaddir . $icon;
					
					if (!move_uploaded_file($_FILES['icon']['tmp_name'], $uploadfile)) {
						$msg =  "Failed to upload Icon Image";
					}
				}
				if ($_FILES['book']['size'] > 0) {
					//save uploaded book file
					$uploaddir = '_data/books/';
					$uploadfile = $uploaddir . $bookfile;
					
					if (!move_uploaded_file($_FILES['book']['tmp_name'], $uploadfile)) {
						$msg =  "Failed to upload Book Image";
					}
				}
				$msg = "Book updated successfully";
				$temp = $product->getId();
				header("Location: product.php?book=$temp&msg=$msg");
				exit;
			}else{
				$msg = "Failed to update Book";
			}
		}
	}
}

$pageTitle = "Book Viewer";
include "_comp/header.php";
?>
 
<!-- Page Content
================================================== -->
<SECTION id=typography>

<p><?php if (isset($_GET['msg']) || $msg != "") { ?><div class="alert alert-block alert-warning fade in">
<button type="button" class="close" data-dismiss="alert">×</button>
<p><?php if (isset($_GET['msg'])) echo $_GET['msg']; else echo $msg;  ?></p></div><?php } ?></p>


<?php	
if (isset($_GET['edit']) && $product!="" && $product !== false) {
	
?>
<form action="product.php?edit=<?php echo $_GET['edit']; ?>" method="post" class="form-horizontal" enctype="multipart/form-data">
	<div class="control-group">
        <label class="control-label" for="name">Name:</label>
        <div class="controls">
            <input id="name" name="name" type="text" value="<?php echo $product->getName(); ?>" />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="price">Price:</label>
        <div class="controls">
            <input name="price" type="text" id="price" value="<?php echo $product->getPrice(); ?>" />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="isbn">ISBN:</label>
        <div class="controls">
            <input name="isbn" type="text" id="isbn" value="<?php echo $product->getIsbn(); ?>" />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="author">Author:</label>
        <div class="controls">
            <input name="author" type="text" id="author" value="<?php echo $product->getAuthor(); ?>" />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="theme">Theme:</label>
        <div class="controls">
            <input name="theme" type="text" id="theme" value="<?php echo $product->getTheme(); ?>" />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="release">Release:</label>
        <div class="controls">
            <input name="release" type="text" id="release" value="<?php echo $product->getRelease(); ?>" />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="category">Category:</label>
        <div class="controls">
            <select name="category" id="category">
        <?php
			$categories = $manager->getCategoryList();
			foreach($categories as $category) {
				echo '<option value="'.$category->getId().'" ';
				if ($product->getCat() == $category->getId())
					echo 'selected="selected"';
				echo '>'.$category->getName().'</option>';	
			}
			if (count($categories) == 0)
				echo '<option value="0">No Category</option>';
		?>
        </select>
        </div>
    </div>
	 <div class="control-group">
        <label class="control-label" for="book">Book File: <em class="text-warning">Leave empty if you do not want to upload new file</em> </label>
        <div class="controls">
            <input type="file" name="book" id="book" />
        </div>
    </div>
     <div class="control-group">
        <label class="control-label" for="icon">Book Icon:<em class="text-warning">Leave empty if you do not want to upload new photo</em> </label>
        <div class="controls">
            <input type="file" name="icon" id="icon" />
        </div>
    </div>
    <div class="control-group">
    <div class="controls">
      <button type="submit" class="btn btn-primary" name="action">Save Changes</button>
    </div>
  </div>
</form>	
    	
</form>
<?php }else if (isset($_GET['book'])){
$book = $manager->viewProduct($_GET['book']);
if ($book === false) {
	echo "<h2>Unable to display book!</h2><p>Either the book no longer exist or it cannot be displayed</p><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>";
}else {
?>
<table class="table table-bordered text-center" width="100%" border="0"\>
  <tr>
    <td>
<H1 id=headings class="text-center"><?php echo $book->getName(); ?></H1></td>
  </tr>
  <tr class="warning">
    <td><H3 class="text-center">By <?php echo $book->getAuthor(); ?></H3></td>
  </tr>
  <tr>
    <td><p  class="text-center"><img class="img-rounded" name="book_icon" src="images/prod_icons/<?php echo $book->getIcon(); ?>" width="500" height="500" alt="<?php echo $book->getName(); ?>" style="background-color: #339966; max-width:500; max-height:500;" align="middle" /></p></td>
    </tr>
  <tr class="success">
    <td>
    <p>Added: <?php $d=new Clock($book->getDate()); echo $d->getDateAdvanced(); ?></p>
    <p>Release Year: <?php echo $book->getRelease(); ?></p>
    <p>Theme: <?php echo $book->getTheme(); ?></p>
    <p>ISBN: <?php echo $book->getIsbn(); ?></p>
    <p>Purchased: <?php echo $book->getPurchase(); ?> times</p>
    <p><b>Price: R<?php echo $book->getPrice(); ?></b></p>
    </td>
  </tr>
  <tr class="success">
    <td>
     
     <?php  
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
			if (isset($_SESSION['user'], $_SESSION['isAdmin']))
				if ($_SESSION['isAdmin'] === true) {
					echo ' <a href="product.php?delete='.$book->getId().'" role="button" class="btn btn-danger">Permenantly delete Product</a>';
					echo ' <a href="product.php?edit='.$book->getId().'" role="button" class="btn btn-primary">Edit Product</a>';
				}
        ?></td>
    </tr>

</table>
<?php } ?>
<p></p>
</SECTION>

<?php
}else{
echo "<h2>No book to display!</h2><p>Please select a book from the catalogue to display</p><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>";	
}
include "_comp/footer.php";
?>