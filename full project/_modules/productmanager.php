<?php
#	Requires the database to be connected
require_once "database.php";
require_once "classes/book.class.php";
require_once "classes/category.class.php";
require_once "classes/transaction.class.php";
require_once "classes/download.class.php";
require_once 'clock.php';

Database::connect();

class ProductManager {
	
	
	public function getCatalogueTop() {
		$query = "SELECT * FROM `books` ORDER BY `books`.`book_purchase` DESC LIMIT 0, 9";
		$result = Database::executeRealQuery($query);
		$books = array();
		while ($row = $result->fetch_assoc()) {
			$book = new Book($row['book_id'], $row['book_name'], $row['cat_id'], $row['book_price'], $row['book_isbn'], $row['book_author'], $row['book_theme'], $row['book_date'], $row['book_filename'], $row['book_icon'], $row['book_release'], $row['book_purchase']);
			array_push($books, $book);
		}
		return $books;
	}
	
	public function getBooksByCategory($category, $page = 1) {
		if (!is_numeric($page)) {
			echo "Sorry, cannot load feeds at the moment (System says: Incorrect page reference)";
			$page = 0;
		}
		$maxPagePosts = 10;
		$start = (($maxPagePosts*$page)-$maxPagePosts);
		$end = $maxPagePosts*$page;
		$query = "SELECT * FROM `books` WHERE `cat_id`='$category' ORDER BY `book_date` DESC LIMIT $start,$end";
		$books = array();
		$result = Database::executeRealQuery($query);
		while ($row = $result->fetch_assoc()) {
			$book = new Book($row['book_id'], $row['book_name'], $row['cat_id'], $row['book_price'], $row['book_isbn'], $row['book_author'], $row['book_theme'], $row['book_date'], $row['book_filename'], $row['book_icon'], $row['book_release'], $row['book_purchase']);
			array_push($books, $book);
		}
		return $books;
	}
	
	public function addProduct($book_name, $cat_id, $book_price, $book_isbn, $book_author, $book_theme, $book_filename, $book_icon,$book_release) {
		$today = new Clock();
		$today = $today->getDateBasic();
		
		$book_name = Database::clean($book_name);
		$cat_id = Database::clean($cat_id);
		$book_price = Database::clean($book_price);
		$book_isbn = Database::clean($book_isbn);
		$book_author = Database::clean($book_author);
		$book_theme = Database::clean($book_theme);	
		$book_filename = Database::clean($book_filename);
		$book_icon = Database::clean($book_icon);
		$book_release = Database::clean($book_release);			
		
		$query = "INSERT INTO `books` 
		(`book_name`, `cat_id`, `book_price`, `book_isbn`, `book_author`, `book_theme`,`book_date`, `book_filename`, `book_icon`,`book_release`, `book_purchase`)
		VALUES
		('$book_name', '$cat_id', '$book_price', '$book_isbn', '$book_author', '$book_theme', '$today', '$book_filename', '$book_icon','$book_release',0)
		";
		return Database::executeNonQuery($query);
	}
	
	public function viewProduct($id) {
		if (!is_numeric($id)) {
			return false;
		}
		$query = "SELECT * FROM `books` WHERE `book_id`=$id";
		$book = false;
		$result = Database::executeRealQuery($query);
		if (!$result)
			return false;
		while ($row = $result->fetch_assoc()) {
			$book = new Book($row['book_id'], $row['book_name'], $row['cat_id'], $row['book_price'], $row['book_isbn'], $row['book_author'], $row['book_theme'], $row['book_date'], $row['book_filename'], $row['book_icon'], $row['book_release'], $row['book_purchase']);
		}
		return $book;
	}
	
	public function deleteProduct($id) {
		$id = Database::clean($id);
		$query = "DELETE FROM `books` WHERE `book_id`=$id";
		return Database::executeNonQuery($query);		
	}
	
	public function editProduct($id, $book_name, $cat_id, $book_price, $book_isbn, $book_author, $book_theme, $book_filename, $book_icon,$book_release) {
		$book_name = Database::clean($book_name);
		$cat_id = Database::clean($cat_id);
		$book_price = Database::clean($book_price);
		$book_isbn = Database::clean($book_isbn);
		$book_author = Database::clean($book_author);
		$book_theme = Database::clean($book_theme);	
		$book_filename = Database::clean($book_filename);
		$book_icon = Database::clean($book_icon);
		$book_release = Database::clean($book_release);			
		
		$query = "UPDATE `books` SET
		`book_name`='$book_name', `cat_id`='$cat_id', `book_price`='$book_price', `book_isbn`='$book_isbn', `book_author`='$book_author', `book_theme`='$book_theme', `book_filename`='$book_filename', `book_icon`='$book_icon',`book_release`='$book_release' 
		WHERE `book_id`=$id";
		return Database::executeNonQuery($query);
		
	}
	
	public function getTotalProductsPerCategory($cat_id) {
		$query = "SELECT `book_id` FROM `books` WHERE `cat_id`=$cat_id";
		$result = Database::executeRealQuery($query);
		return $result->num_rows;
	}
	
	public function tempCartAdd($id) {		
		if (!isset($_SESSION['cart']))
			$_SESSION['cart'] = array();
		array_push($_SESSION['cart'], $id);
	}
	
	public function tempCartRemove($id) {		
		if (!isset($_SESSION['cart']))
			$_SESSION['cart'] = array();
		for ($x=0;$x<count($_SESSION['cart']);$x++) {
			if ($_SESSION['cart'][$x] == $id) {
				array_splice($_SESSION['cart'], $x, 1);
			}
		}
	}
	
	public function tempCartCheck($id) {
		if (!isset($_SESSION['cart']))
			$_SESSION['cart'] = array();
		for ($x=0;$x<count($_SESSION['cart']);$x++) {
			if ($_SESSION['cart'][$x] == $id) {
				return true;
			}
		}
		return false;
	}
	
	public function tempCartView() {
		$books = array();
		if (isset($_SESSION['cart'])) {
			foreach ($_SESSION['cart'] as $id) {
				$query = "SELECT * FROM `books` WHERE `book_id`=" . $id;
				$result = Database::executeRealQuery($query);
				while ($row = $result->fetch_assoc()) {
					$book = new Book($row['book_id'], $row['book_name'], $row['cat_id'], $row['book_price'], $row['book_isbn'], $row['book_author'], $row['book_theme'], $row['book_date'], $row['book_filename'], $row['book_icon'], $row['book_release'], $row['book_purchase']);
					array_push($books, $book);
				}
			}
		}
		return $books;
	}
	
	public function tempCartTotalBooks() {
		if (isset($_SESSION['cart']))
			return count($_SESSION['cart']);
		else
			return 0;		
	}
	
	public function tempCartTotalPrice() {
		$books = $this->tempCartView();
		$price = 0.0;
		foreach($books as $book) {
			$price += $book->getPrice();	
		}
		return $price;
	}
	
	public function tempCartClear() {
		if (isset($_SESSION['cart']))
			unset($_SESSION['cart']);
	}
	
	public function permCartAdd($id) {
		$cust_id = Database::clean($_SESSION['user']);
		$query = "INSERT INTO `cart` (`book_id`,`cust_id`) VALUES ($id, '$cust_id')";
		return Database::executeNonQuery($query);		
	}
	
	public function permCartRemove($id) {		
		$cust_id = Database::clean($_SESSION['user']);
		$query = "DELETE FROM `cart` WHERE `book_id`=$id AND `cust_id`='$cust_id'";
		return Database::executeNonQuery($query);		
	}
	
	public function permCartCheck($id) {
		$cust_id = Database::clean($_SESSION['user']);
		$query = "SELECT * FROM `cart` WHERE `book_id`='$id' AND `cust_id`='$cust_id'";
		$result = Database::executeRealQuery($query);
		if ($result->num_rows > 0)
			return true;
		return false;
	}
	
	public function permCartView() {
		$books = array();
		$cust_id = Database::clean($_SESSION['user']);
		$query = "SELECT * FROM `cart` WHERE cust_id='$cust_id'";
		$result = Database::executeRealQuery($query);
		$temp = array();
		while ($row = $result->fetch_assoc())
			array_push($temp, $row['book_id']);
		$result->free();
		
		foreach ($temp as $id) {
				$query = "SELECT * FROM `books` WHERE `book_id`=" . $id;
				$result = Database::executeRealQuery($query);
				while ($row = $result->fetch_assoc()) {
					$book = new Book($row['book_id'], $row['book_name'], $row['cat_id'], $row['book_price'], $row['book_isbn'], $row['book_author'], $row['book_theme'], $row['book_date'], $row['book_filename'], $row['book_icon'], $row['book_release'], $row['book_purchase']);
					array_push($books, $book);
				}
			}
		//$result->free();
		return $books;
	}
	
	public function permCartTotalBooks() {
		$cust_id = Database::clean($_SESSION['user']);
		$query = "SELECT * FROM `cart` WHERE `cust_id`='$cust_id'";
		$result = Database::executeRealQuery($query);
		return $result->num_rows;
	}
	
	public function permCartTotalPrice() {
		$books = $this->permCartView();
		$price = 0.0;
		foreach($books as $book) {
			$price += $book->getPrice();	
		}
		return $price;
	}
	
	public function permCartClear() {
		$cust_id = Database::clean($_SESSION['user']);
		$query = "DELETE FROM `cart` WHERE `cust_id`='$cust_id'";
		return Database::executeNonQuery($query);	
	}
	
	
	
	
	public function getCategoryList() {
		$query = "SELECT * FROM `categories`";
		$result = Database::executeRealQuery($query);
		$categories = array();
		while ($row = $result->fetch_assoc()) {
			$category = new Category($row['cat_id'], $row['cat_name'], $row['cat_desc'], $row['cat_date']);
			array_push($categories, $category);
		}
		return $categories;
	}
	
	public function getRecentCategories() {
		$query = "SELECT * FROM `categories` ORDER BY `cat_date` DESC LIMIT 0,5";
		$result = Database::executeRealQuery($query);
		$categories = array();
		while ($row = $result->fetch_assoc()) {
			$category = new Category($row['cat_id'], $row['cat_name'], $row['cat_desc'], $row['cat_date']);
			array_push($categories, $category);
		}
		return $categories;
	}
	
	public function countCategories() {
		$query = "SELECT * FROM `categories`";
		$result = Database::executeRealQuery($query);
		return $result->num_rows;
	}
	
	public function addCategory($name, $desc) {
		$name = Database::clean($name);
		$desc = Database::clean($desc);
		$date = new Clock();
		$date = $date->getDateBasic();
		$query = "INSERT INTO `categories` (`cat_name`, `cat_desc`, `cat_date`) VALUES ('$name','$desc','$date')";
		return Database::executeNonQuery($query);
	}
	
	public function deleteCategory($id) {
		$id = Database::clean($id);
		$query2 = "DELETE FROM `categories` WHERE `cat_id`=$id";
		$query = "DELETE FROM `books` WHERE `cat_id`=$id";
		Database::executeNonQuery($query);
		return Database::executeNonQuery($query2);
	}
	
	public function viewCategory($id) {
		if (is_numeric($id)) {
		$query = "SELECT * FROM `categories` WHERE `cat_id`=$id";
		$result = Database::executeRealQuery($query);
		$row = $result->fetch_assoc();
		$category = new Category($row['cat_id'], $row['cat_name'], $row['cat_desc'], $row['cat_date']);
		return $category; }
	}
	
	public function editCategory($id, $name, $desc) {
		$name = Database::clean($name);
		$desc = Database::clean($desc);
		$query = "UPDATE `categories` SET `cat_name`='$name', `cat_desc`='$desc' WHERE `cat_id`=$id";
		return Database::executeNonQuery($query);
	}
	
	private function getRecentTransaction($cust_id) {
		$query = "SELECT * FROM `transaction` WHERE `cust_id`='$cust_id' ORDER BY `trans_date` DESC";
		$result = Database::executeRealQuery($query);
		$row = $result->fetch_assoc();
		return new Transaction($row['trans_id'],$row['cust_id'], $row['trans_numbooks'], $row['trans_date']);

	}
	
	public function shipItems() {
		$cust_id = Database::clean($_SESSION['user']);
		$date = new Clock();
		$date = $date->getDateBasic();
		//create transaction record
		$totalbooks = $this->permCartTotalBooks();
		$query = "INSERT INTO `transaction` (`cust_id`,`trans_numbooks`,`trans_date`) VALUES ('$cust_id', $totalbooks, '$date')";
		$comp1 = Database::executeNonQuery($query);
		//create downloads records
		$books = $this->permCartView();
		foreach ($books as $book) {
			$down_code = rand(1000,999999);
			$down_num = 3;
			$book_filename = $book->getFilename();
			$trans = $this->getRecentTransaction($cust_id);
			$trans = $trans->getId();
			$query = "INSERT INTO `download` (`cust_id`, `down_code`, `book_filename`, `down_date`, `down_number`, `trans_id`) VALUES ('$cust_id',$down_code,'$book_filename','$date',$down_num,$trans)";
			$comp2 =  Database::executeNonQuery($query);
		}
		$this->permCartClear();
		if ($comp1 && $comp2)
			return true;
		return false;
	}
	
	public function download($code) {
		if (!is_numeric($code))
			return "";
		$cust_id = Database::clean($_SESSION['user']);
		//fetch associated download
		$query = "SELECT * FROM `download` WHERE `down_code`=$code AND `cust_id`='$cust_id'";
		$result = Database::executeRealQuery($query);
		if (!$result)
			return "";
		if ($result->num_rows < 0)
			return "";
		$row = $result->fetch_assoc();
		$download = new Download($row['down_id'], $row['cust_id'], $row['down_code'], $row['book_filename'],$row['down_date'],$row['down_number'], $row['trans_id']);
		if ($download->getNumber() > 0) {
		$download_number = $download->getNumber() - 1;
		$id = $download->getId();
		$query = "UPDATE `download` SET `down_number`=$download_number WHERE `down_id`=$id";
			Database::executeNonQuery($query);
			
			return $download->getFilename();
		}else{
			return "";
		} 
	}
	
	public function listDownloads() {
		$cust_id = Database::clean($_SESSION['user']);
		$query = "SELECT * FROM `download` WHERE `cust_id`='$cust_id'";
		$result = Database::executeRealQuery($query);
		if (!$result)
			return array();
		$downloads = array();
		while ($row = $result->fetch_assoc()) {
			$download = new Download($row['down_id'], $row['cust_id'], $row['down_code'], $row['book_filename'],$row['down_date'],$row['down_number'], $row['trans_id']);
			array_push($downloads, $download);
		}
		return $downloads;		
	}
	
	function search($q, $page) {
		$q = Database::clean($q);
		if (!is_numeric($page)) {
			echo "Sorry, cannot load feeds at the moment (System says: Incorrect page reference)";
			$page = 0;
		}
		$maxPagePosts = 10;
		$start = (($maxPagePosts*$page)-$maxPagePosts);
		$end = $maxPagePosts*$page;
		$query = "SELECT * FROM `books` WHERE `book_name` LIKE '%$q%' OR `book_author` LIKE '%$q%' ORDER BY `book_name` ASC LIMIT $start,$end";
		$books = array();
		$result = Database::executeRealQuery($query);
		while ($row = $result->fetch_assoc()) {
			$book = new Book($row['book_id'], $row['book_name'], $row['cat_id'], $row['book_price'], $row['book_isbn'], $row['book_author'], $row['book_theme'], $row['book_date'], $row['book_filename'], $row['book_icon'], $row['book_release'], $row['book_purchase']);
			array_push($books, $book);
		}
		return $books; 
	}
	
}

?>