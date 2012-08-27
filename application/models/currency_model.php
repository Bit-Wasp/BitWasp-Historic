<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Currency_model extends CI_Model {

	public function __construct(){}

	// Load symbol by currency ID.
	public function get_symbol($id){
		$query = $this->db->get_where('currencies', array('id' => $id));
		$result = $query->row_array();
		
		// Check the currency exists.
		if(isset($result)){
			// Success; return the symbol.
			return $result['symbol'];
		} else {
			// Failure; No currency found. return NULL;
			return NULL;
		}
	}
	
	// Load a list of currencies.
	public function getList(){
		$array = array();
		$query = $this->db->get('currencies');
		if($query->num_rows() > 0){
			// If there are currencies, loop through each.
			foreach($query->result() as $result){
				$tmp = array('id' => $result->id,
					     'name' => $result->name,
					     'symbol' => $result->symbol );
				// Build an array of the currencies attributes
				array_push($array,$tmp);
			}

			// Success; return the result. 
			return $array;			
		} else {
			// Failure; no currencies. return NULL.
			return NULL;
		}
	}

};

