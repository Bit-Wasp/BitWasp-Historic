<?php

class General {

	public function generateSalt(){
		$rand = mt_rand(12,24);
		$salt = "";

		for($i = 0; $i < $rand; $i++){
			$salt.= chr(rand(97,125));
		}

		return $salt;
	}

        public function hashFunction($pass,$salt){
                return hash('sha256',$pass.hash('sha256',$salt));
        }

	public function randHash(){
		return substr($this->hashFunction($this->generateSalt(),$this->generateSalt()),0,16);
	}

	public function uniqueHash($table, $column){
		$CI = &get_instance();
		$CI->load->model('general_model');
		$found = FALSE;

		$hash = $this->randHash();
		$test = $CI->general_model->testUniqueHash($table, $column, $hash);
		while($test == TRUE){
			$hash = $this->randHash();
			$test = $this->general_model->testUniqueHash($table, $column, $hash);	
		}

		return $hash;
	}

};

