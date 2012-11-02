<?php

class General {

	public function importPGPkey($ascii){
		$CI = &get_instance();
		$gpg = $this->initPGP();
		if(function_exists('gnupg_init')){
			$info = gnupg_import($gpg,$ascii);
		} else if(class_exists('gnupg')){
			$info = $gpg->import($ascii);
		}
		return $info;
	}

	public function initPGP(){
                if(function_exists('gnupg_init')){
                        $gpg = gnupg_init();
                } else if(class_exists('gnupg')){
                        $gpg = new gnupg();
                }
		return $gpg;
	}

	public function encryptPGPmessage($fingerprint,$messageText){
		$gpg = $this->initPGP();
		if(function_exists('gnupg_init')){
	                gnupg_addencryptkey($gpg, $fingerprint);
	                $messageText = gnupg_encrypt($gpg, "$messageText\n");
		} else if(class_exists('gnupg')){
			$gpg->addencryptkey($fingerprint);
			$messageText = $gpg->encrypt($gpg, "$messageText\n");
		}

                $messageText = "-----BEGIN PGP MESSAGE-----\nComment: Server Side Encryption\n".substr($messageText,28);
		return $messageText;
        }

	// Determine the required authorization for a page based on first URI segment.
	public function getAuthLevel($URI){
		$CI = &get_instance();
		// Select required level from the DB.
		$CI->db->select('authLevel')
			 ->where(array('URI' => $URI));
		$query = $CI->db->get('pageAuthorization');
		if($query->num_rows() > 0){
			// If the entry exists, return the value to the table.
			$row = $query->row_array();
			return $row['authLevel'];
		} 
			//Failed, return false. Force users to log in.
			return false;
		
	}


	// Generate a salt for encryption.
	public function generateSalt(){
		// Generate a string of random length.
		$rand = mt_rand(12,24);
		$salt = "";

		// Loop through each position, and select a random character.
		for($i = 0; $i < $rand; $i++){
			$salt.= chr(mt_rand(97,125));
		}

		// Return the generated salt.
		return $salt;
	}

	// Hash a string with a salt.
        public function hashFunction($pass,$salt){
                return hash('sha256',$pass.hash('sha256',$salt));
        }

	// Generate an identifying hash for users, items, etc.
	public function randHash(){
		return substr($this->hashFunction($this->generateSalt(),$this->generateSalt()),0,16);
	}

	// Generate a unique hash for the specified table/column.
	public function uniqueHash($table, $column){
		// Load CodeIgniter class.
		$CI = &get_instance();
		$CI->load->model('general_model');

		$found = FALSE;

		// Generate a random hash. 
		$hash = $this->randHash();
		
		// Test the DB, see if the hash is unique. 
		$test = $CI->general_model->testUniqueHash($table, $column, $hash);

		while($test == TRUE){
			// If the test says the hash is not unique, generate another
			$hash = $this->randHash();
			// Perform the test again, and see if the loop goes on.
			$test = $this->general_model->testUniqueHash($table, $column, $hash);	
		}

		// Finally return the generated unique hash.
		return $hash;
	}

	public function currentURI(){
		// Count the number of entries in the base_url's URI
		$baseUrl = base_url();
		$separateBaseUrl = explode('//',$baseUrl);
		$baseURI = explode('/',$separateBaseUrl[1]);
		$baseURIcount = count($baseURI)-2;
	
		// Load the current requests URI
		$request = substr($_SERVER['REQUEST_URI'],1); 
		$reqURI = explode('/',$request);
	
		$URI = array();
		$pos = 0;
		// Begin after the entries in the base_url's URI
		for($i = $baseURIcount; $i < count($reqURI); $i++){
			$URI[$pos++] = $reqURI[$i];
		}
		return $URI;
	}

	// Format time into a readable format.
	public function displayTime($timestamp){
		// Load the current time, and check the difference between the times in seconds.
		$currentTime = time();
		$difference = $currentTime-$timestamp;

		if ($difference < 60) {				// within a minute.
			return 'less than a minute ago';
		} else if($difference < 120) {			// 60-120 seconds.
			return 'about a minute ago';
		} else if($difference < (60*60)) {		// Within the hour. 
			return round($difference / 60) . ' minutes ago';
		} else if($difference < (120*60)) {		// Within a few hours.
			return 'about an hour ago';
		} else if($difference < (24*60*60)) {		// Within a day.
			return 'about ' . round($difference / 3600) . ' hours ago';
		} else if($difference < (48*60*60)) {		// Just over a day.
			return '1 day ago';
		} else {					// Otherwise just return the basic date.		
			if($timestamp == '0'){
				return '0';
			}
			return date('j F Y',$timestamp);
		}
	}
};

