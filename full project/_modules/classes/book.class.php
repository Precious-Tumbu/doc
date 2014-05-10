<?php

class Book {
	
	private $book_id;
	private $book_name;
	private $cat_id;
	private $book_price;
	private $book_isbn;
	private $book_author;
	private $book_theme;
	private $book_date;
	private $book_filename;
	private $book_icon;
	private $book_release;
	private $book_purchase;
	
	//constructor
	public function __construct($book_id, $book_name, $cat_id, $book_price, $book_isbn, $book_author, $book_theme,$book_date, $book_filename, $book_icon,$book_release, $book_purchase) {
		$this->book_id = $book_id;
		$this->book_name = $book_name;
		$this->book_author = $book_author;
		$this->cat_id = $cat_id;
		$this->book_release = $book_release;
		$this->book_isbn = $book_isbn;
		$this->book_price = $book_price;
		$this->book_icon = $book_icon;
		$this->book_theme = $book_theme;
		$this->book_date = $book_date;
		$this->book_filename = $book_filename;
		$this->book_purchase = $book_purchase;
	}
	
	//Mutators
	public function setName($value) {
		$this->book_name = $value;
	}
	public function setAuthor($value) {
		$this->book_author = $value;
	}
	public function setCat($value) {
		$this->cat_id = $value;
	}
	public function setRelease($value) {
		$this->book_release = $value;
	}
	public function setIsbn($value) {
		$this->book_isbn = $value;
	}
	public function setPrice($value) {
		$this->book_price = $value;
	}
	public function setIcon($value) {
		$this->book_icon = $value;
	}
	public function setTheme($value) {
		$this->book_theme = $value;
	}
	public function setDate($value) {
		$this->book_date = $value;
	}
	public function setFilename($value) {
		$this->book_filename = $value;
	}
	public function setPurchase($value) {
		$this->book_purchase = $value;
	}
	
	//Accessors
	public function getId() {
		return $this->book_id;
	}
	public function getName() {
		return $this->book_name;
	}
	public function getCat() {
		return $this->cat_id;
	}	
	public function getPrice() {
		return $this->book_price;
	}
	public function getIsbn() {
		return $this->book_isbn;
	}
	public function getAuthor() {
		return $this->book_author;
	}
	public function getTheme() {
		return $this->book_theme;
	}
	public function getDate() {
		return $this->book_date;
	}
	public function getFilename() {
		return $this->book_filename;
	}
	public function getIcon() {
		return $this->book_icon;
	}
	public function getRelease() {
		return $this->book_release;
	}
	public function getPurchase() {
		return $this->book_purchase;
	}
	
}

?>