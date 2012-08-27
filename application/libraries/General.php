<?php

class General {

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
			return date('j F Y');
		}
	}
};

