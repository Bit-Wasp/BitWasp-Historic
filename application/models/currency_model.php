<?php
class Currency_model extends CI_Model {

	public function __construct(){}

	public function get_symbol($id){
		$query = $this->db->get_where('currencies', array('id' => $id));
		$result = $query->result_array();
		return $result['0']['symbol'];
	}

};

