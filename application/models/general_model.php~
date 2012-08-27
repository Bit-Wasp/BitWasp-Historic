<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General_model extends CI_Model {
	
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


	// Determine the required authorization for a page based on first URI segment.
	public function getAuthLevel($URI){
		// Select required level from the DB.
		$this->db->select('authLevel')
			 ->where(array('URI' => $URI));
		$query = $this->db->get('pageAuthorization');
		if($query->num_rows() > 0){
			// If the entry exists, return the value to the table.
			$row = $query->row_array();
			return $row['authLevel'];
		} else {
			// Failed, return false. Force users to log in.
			return false;
		}
	}
};


