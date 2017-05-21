<?php

class Tenant extends Base {

	function __construct($pdoDB) {
       parent::__construct($pdoDB);
    }
	
	public function gets() {
		$query = $this->db->prepare("SELECT * FROM tenants");
		
		try {
			$query->execute();
			return $query->fetchAll();
		} catch (Exception $e) {
			throw new DavidsException('Failed to fetch tenant list');
		}
	}
	
	public function get() {
		echo 'GET ';
	}
	
	public function update() {
		echo 'UPDATE ';
	}
	
	public function del() {
		echo 'DELETE ';
	}
	
	
}