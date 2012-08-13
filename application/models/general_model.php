<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General_model extends CI_Model {
	
	public function testUniqueHash($table, $column, $hash){
		$this->db->where($column, $hash);
		$query = $this->db->get($table);
		if($query->num_rows() > 0){
			return TRUE;
		} else {
			return FALSE;
		}
	}

};


