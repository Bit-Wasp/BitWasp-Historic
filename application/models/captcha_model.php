<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Captcha_model extends CI_Model {

	public function __construct(){	}

	public function setCaptcha($key,$code){
		$data = array(	'key' => $key,
				'characters' => $code,
				'time' => time()
				);
		$this->db->insert('captchas',$data);
	}


	public function getCode($key){
		$this->db->select('characters')
			->from('captchas')
			->where('key',$key);

		$query = $this->db->get();
		if($query->num_rows() == 0){
			// key invalid, captcha has expired.
			return NULL;
		} 

		return $query->row_array();
		
	}
};
