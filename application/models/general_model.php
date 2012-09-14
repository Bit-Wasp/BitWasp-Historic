<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General_model extends CI_Model {

	public function siteConfig(){
		$query = $this->db->get('config');
		if($query->num_rows() > 0){
			$res = $query->row_array();
			$json = json_decode($res['jsonConfig']);
			return $json;
		} else {
			return NULL;
		}
	}
	
	// Test to see if the hash is unique in the table/column.
	public function testUniqueHash($table, $column, $hash){
		$this->db->where($column, $hash);
		$query = $this->db->get($table);
		if($query->num_rows() > 0){
			// Success; hash exists. return TRUE.
			return TRUE;
		} else {
			// Failure; hash does not exist.
			return FALSE;
		}
	}



};


