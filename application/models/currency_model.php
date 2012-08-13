<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Currency_model extends CI_Model {

	public function __construct(){}

	public function get_symbol($id){
		$query = $this->db->get_where('currencies', array('id' => $id));
		$result = $query->row_array();
		//print_r($result);
		if(isset($result)){
			return $result['symbol'];
		} else {
			return NULL;
		}
	}
	
	public function getList(){
		$array = array();
		$query = $this->db->get('currencies');
		foreach($query->result() as $result){
			$tmp = array('id' => $result->id,
				     'name' => $result->name,
				     'symbol' => $result->symbol );
			array_push($array,$tmp);
		}
		if(count($array) > 0){
			return $array;
		} else {
			return NULL;
		}
	}

};

