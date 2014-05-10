<?php

class Category {
	
	private $cat_id;
	private $cat_name;
	private $cat_desc;
	private $cat_date;
	
	//constructor
	public function __construct($cat_id, $cat_name, $cat_desc, $cat_date) {
		$this->cat_id = $cat_id;
		$this->cat_name = $cat_name;
		$this->cat_desc = $cat_desc;
		$this->cat_date = $cat_date;	
	}
	
	//getters
	public function setId($value) {
		$this->cat_id = $value;	
	}
	public function setName($value) {
		$this->cat_name = $value;		
	}
	public function setDesc($value) {
		$this->cat_desc = $value;		
	}
	public function setDate($value) {
		$this->cat_date = $value;	
	}
	
	//setters
	public function getId() {
		return $this->cat_id;	
	}
	public function getName() {
		return $this->cat_name;	
	}
	public function getDesc() {
		return $this->cat_desc;	
	}
	public function getDate() {
		return $this->cat_date;	
	}
	
}

?>