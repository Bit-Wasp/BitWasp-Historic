<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General_model extends CI_Model {

	// Function to update the sites configuration. Takes a json string as input.
	public function updateConfig($json){
		$changes = array('jsonConfig' => $json);
		$this->db->where('id',1);
		if($this->db->update('config',$changes)){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	// Load site configuration
	public function siteConfig(){
		// Get row from the table
		$query = $this->db->get('config');
		if($query->num_rows() > 0){
			$res = $query->row_array();
			// Decode the json string, and return the json object
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


