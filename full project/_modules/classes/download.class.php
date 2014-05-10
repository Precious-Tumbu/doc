<?php

class Download {
	
	private $down_id;
	private $cust_id;
	private $down_code;
	private $book_filename;
	private $down_date;
	private $down_number;
	private $trans_id;
	
	//constructor
	public function __construct($down_id, $cust_id, $down_code, $book_filename, $down_date, $down_number, $trans_id) {
		$this->down_id = $down_id;
		$this->cust_id = $cust_id;
		$this->down_code = $down_code;
		$this->book_filename = $book_filename;
		$this->down_date = $down_date;
		$this->down_number = $down_number;
		$this->trans_id = $trans_id;
	}
	
	//Mutators
	public function setCustomer($value) {
		$this->cust_id = $value;
	}
	public function setCode($value) {
		$this->down_code = $value;
	}
	public function setFilename($value) {
		$this->book_filename = $value;
	}
	public function setDate($value) {
		$this->down_date = $value;
	}
	public function setNumber($value) {
		$this->down_number = $value;
	}
	public function setTransId($value) {
		$this->trans_id = $value;
	}
	
	//Accessors
	public function getId() {
		return $this->down_id;
	}
	public function getCustomer() {
		return $this->cust_id;
	}
	public function getCode() {
		return $this->down_code;
	}
	public function getFilename() {
		return $this->book_filename;
	}
	public function getDate() {
		return $this->down_date;
	}
	public function getNumber() {
		return $this->down_number;
	}
	public function getTransId() {
		return $this->trans_id;
	}
	
	
}

?>