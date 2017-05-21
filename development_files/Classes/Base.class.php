<?php

abstract class Base {
	/**
	 * The ID of the current instance of the object
	 */
	public $id = 0;
	
	/**
	 * Access the globally declared database connection
	 * Dirty but hey, it works! #prototype
	 */
	public static $db;
	
	/**
	 * The constructor is called when a new instance of the object is created
	 * Always pass the PDO database connector into the object so it can make DB queries
	 */
	function __construct($pdoDB) {
		$this->db = $pdoDB;
	}
	
	/**
	 * Generates a list of all instances of the object
	 */
	abstract public function gets();
	
	/**
	 * Populates the current instance of the object with the data from the database
	 */
	abstract public function get();
	
	/**
	 * Updates the database of the current instance of the object
	 */
	abstract public function update();
	
	/**
	 * Deletes the current instance of the object in the database
	 */
	abstract public function del();
}