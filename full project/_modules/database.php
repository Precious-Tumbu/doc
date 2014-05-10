<?php

/**	Database class manages MySQL database connections
*	Class is static to improve performance and memory
*	Class requires settings.php
*/

require_once "settings.php";

class Database {
	
	private static $link;
	
	// Creates a connection to MySQL Database, must be called before any other function on this class is called
	public static function connect() {
		$host = MYSQL_HOST;
		$user = MYSQL_USER;
		$pass = MYSQL_PASS;
		$database = MYSQL_DATABASE;
		
		if (empty($host))
			$host = "localhost";
		if (empty($user))
			$user = "root";
		if (empty($pass))
			$pass = "";
		if (empty($database))
			$database = "freshone";
        /*        
        $host = "localhost";
		$user = "root";
		$pass = "";
		$database = "smg_db";*/
		
		Database::$link = new mysqli($host, $user, $pass, $database);
		if (Database::$link->connect_error) {
			if (!headers_sent()) {
				header("Location: error.php?fatalError=".Database::$link->connect_error);
			}else{
				echo "Database Error";
			}
			exit;
		}
	}
	
	// Executes a piece of given query that does not return results i.e. INSERT, UPDATE, DELETE, CREATE
	// Returns a boolean indicating success of failure
	public static function executeNonQuery($query) {
		return Database::$link->real_query($query);
	}
	
	// Executes a piece of given query that returns results i.e. SELECT
	// Returns mysqli_result object containing the results of the query
	public static function executeRealQuery($query) {
		return Database::$link->query($query);
	}
	
	//returns whether the database is initialized or not, returns true if connected or false if not connected
	public static function status() {
		return !empty(Database::$link);
	}
	
	//Returns the last error from the previous query executed
	public static function lastError() {
		return Database::$link->error;
	}
	
	//Returns cleaned data for insertion in query, warning do not place a query through this function
	public static function clean($data) {
		return Database::$link->real_escape_string($data);
	}
	
	// Explicitly closes the database connection
	public static function close() {
		Database::$link->close();
	}

}

?>