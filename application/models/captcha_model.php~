<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Captcha_model extends CI_Model {

	public function __construct(){	}

	// Insert the captcha to the table.
	public function setCaptcha($key,$code){
		$data = array(	'key' => $key,
				'characters' => $code,
				'time' => time()
				);
		if($this->db->insert('captchas',$data)){
			// Success; captcha added to the table.
			return TRUE;
		} else {
			// Failure; unable to add captcha.
			return FALSE;
		}
	}

	// Load captcha by the session key.
	public function getCode($key){
		$this->db->select('characters')
			->from('captchas')
			->where('key',$key);

		// Check the captcha exists.
		$query = $this->db->get();
		if($query->num_rows() == 0){
			// Failure; key invalid, captcha has expired.
			return NULL;
		} else {
			// Success; return the captcha code.
			return $query->row_array();
		}
		
	}
};
