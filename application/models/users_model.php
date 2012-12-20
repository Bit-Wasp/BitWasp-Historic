<?php 

class Users_Model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
	}

	public function registrationTokenRole($token){
		$this->db->select('role');
		$query = $this->db->get_where('registrationTokens',array('content' => $token));
		if($query->num_rows() > 0){
			$res = $query->row_array();
			$id = 0;
			switch($res['role']){
				case 'Admin':
					$id = '3';
					break;
				case 'Vendor':
					$id = '2';
					break;
				case 'Buyer':
					$id = '1';
					break;
				default:
					$id = '1';
					break;
			}
			return array(	'int'	=> $id,
					'str'	=> $res['role']);
		} else {
			return NULL;
		}
	}

	public function checkRegistrationToken($token){
		$query = $this->db->get_where('registrationTokens',array('content' => $token));
		if($query->num_rows() > 0){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function removeRegistrationToken($hash){
		$this->db->where('hash', "$hash");
		if($this->db->delete('registrationTokens')){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function listRegistrationTokens(){
		$results = array(	'Admin' => null,
					'Buyer' => null,
					'Vendor' => null );		

		$this->db->where('role','Admin');
		$this->db->select('hash, content');
		$query = $this->db->get('registrationTokens');
		if($query->num_rows() > 0){
			$results['Admin'] = $query->result_array();
		}

		$this->db->where('role','Vendor');
		$this->db->select('hash, content');
		$query = $this->db->get('registrationTokens');
		if($query->num_rows() > 0){
			$results['Vendor'] = $query->result_array();
		}

		$this->db->where('role','Buyer');
		$this->db->select('hash, content');
		$query = $this->db->get('registrationTokens');
		if($query->num_rows() > 0){
			$results['Buyer'] = $query->result_array();
		}
		return $results;
	}

	public function addRegistrationToken($array){
		if($this->db->insert('registrationTokens',$array)){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	// Check the submitted PGP two step token against whats on record.
	public function checkTwoStepChallenge($userID,$solution){
		$this->db->where('userID',$userID);
		$this->db->where('twoStepChallenge',$solution);
		$query = $this->db->get('twoStep');

		// Return true if the token matches.
		if($query->num_rows() > 0){
			return TRUE;
		} else {
			// Otherwise return false.
			return FALSE;
		}
	}

	// Add the generated two-step token to a table.
	public function addTwoStepChallenge($userID, $challenge){
		// Remove any old challenges for this user.
		$query = $this->db->get_where('twoStep', array('userID' => $userID));
		if($query->num_rows() > 0){
			$this->db->where('userID',$userID);
			$this->db->delete('twoStep');
		} 

		// Record the challenge for the user.
		$update = array('userID' => $userID,
				'twoStepChallenge' => $challenge);
		if($this->db->insert('twoStep',$update)){
			// Challenge has been recorded.
			return TRUE;
		} else {
			// Unable to record challenge.
			return FALSE;
		}
	}

	// Return the basic info for logging in. 
	public function getLoginInfo($user = FALSE){
		// Select the entries by username.
		$this->db->select('id, userName,userSalt, userHash, userRole, twoStepAuth, items_per_page');

        	//Check what field has been provided, and query database using that field.
        	if (isset($user['userHash'])) {
			$query = $this->db->get_where('users', array('userHash' => $user['userHash']));
		} elseif (isset($user['id'])) {
			$query = $this->db->get_where('users', array('id' => $user['id']));
		} elseif (isset($user['userName'])) { 
			$query = $this->db->get_where('users', array('userName' => $user['userName']));
		} else {
			return FALSE; //No suitable field found.
		}

		// Check if the result exists. 
		if($query->num_rows() > 0){
			// Return the results
			return $query->row_array();
		} else {
			// No results for this username.
			return false;
		}
	}
	

	public function addUser($userData,$token){
		// Insert the array into the users table.
		$query = $this->db->insert('users',$userData);
		if(!$query){
			return FALSE;
		}

		// If the user had a registration token, remove it.
		if($token !== NULL){
			$this->db->where('content',"$token");
			if(!$this->db->delete('registrationTokens'))
				return FALSE;
		}
		return TRUE;
	}

	// Update the last login time.
	public function setLastLog($username){
		// Update the table.
		$userdata = array('lastLog' => time());
		$this->db->where('username',$username);
		$query = $this->db->update('users',$userdata);
		
		// Test whether the query was successful.
		if($query){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	// Test the submitted username and encrypted password.
	public function checkPass($username,$hash){

		// Select id from the table, with the submitted entries. 
		$this->db->select('id');
		$query = $this->db->get_where('users', array(	'userName' => $username,
								'password' => $hash ));

		// If the result exists, return TRUE.
		if($query->num_rows() > 0){
			return TRUE;
		} else {
			// Otherwise, return FAIL.
			return FALSE;
		}
	}

	public function updateActivity($userHash){
		$this->db->where('userHash',$userHash);
		$query = $this->db->update('users', array('last_activity' => time()));
		if($query){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function users($userHash = NULL){
		$this->db->select('userName, userHash, userRole, location, timeRegistered, last_activity');
		if($userHash !== NULL){
			$this->db->where('userHash',$userHash);
		}
	
		$query = $this->db->get('users');
		if($query->num_rows() > 1){
			return $query->result_array();
		} else if($query->num_rows() == '1' || $userHash !== NULL){
			$res = $query->row_array();
			return array(	'userName' => $res['userName'],
					'userHash' => $res['userHash'],
					'userRole' => $res['userRole'],
					'location' => $res['location'],
					'last_activity' => $this->general->displayTime($res['last_activity']),
					'timeRegistered' => $this->general->displayTime($res['timeRegistered']) );
		} else {
			return NULL;
		}
	}

        //Load the requested user from the database by their the specified field.
        public function get_user($user = FALSE)
        {
		if($user === FALSE)
			return FALSE;

		//Select these fields from the database
		$this->db->select('id, userName, userRole, userHash, rating, timeRegistered, twoStepAuth, forcePGPmessage, profileMessage, userSalt, items_per_page, showActivity, last_activity');

                //Check what field has been provided, and query database using that field.
                if (isset($user['userHash'])) {
			$query = $this->db->get_where('users', array('userHash' => $user['userHash']));
		} elseif (isset($user['id'])) {
			$query = $this->db->get_where('users', array('id' => $user['id']));
		} elseif (isset($user['userName'])) { 
			$query = $this->db->get_where('users', array('userName' => $user['userName']));
		} else {
			return FALSE; //No suitable field found.
		}

		//If there is a matching row, it is returned to the user
		if($query->num_rows() > 0){
			// Build the initial results array.
			$results = $query->row_array();

			// Make the time look nicer!
			$results['dispTime'] = $this->general->displayTime($results['timeRegistered']);

			// Check if the user has disabled their latest activity being displayed.
			if($results['showActivity'] == '0'){
				$results['last_activity'] = NULL;
			} else {
				// If it's enabled, make it look nicer before being displayed on the page.
				$results['last_activity'] = $this->general->displayTime($results['last_activity']);
			}
	
	                return $results;
		} else {
			return FALSE;
		}
        }

	//Retrive this users public key.
        public function get_pubKey_by_id($id = FALSE, $fingerprint = NULL)
        {
                //If no user is specified, return nothing.
                if ($id === FALSE) {
                        return NULL;
                }

                //Otherwise, load the public key which corresponds to this ID.
		if($fingerprint == NULL){
			$info = 'key';
		} else {
			$info = 'fingerprint';		
	        }

		$this->db->select($info);                
		$query = $this->db->get_where('publicKeys', array('userId' => $id));

		// If there is a key, return the value.
		if ($query->num_rows() > 0) {
			$result = $query->row_array();
			return $result[$info];
		}

		// Otherwise return NULL.
		return NULL;
        }

	// Delete public key by user id.
	public function drop_pubKey_by_id($id = FALSE){
		if($id === FALSE)
			return NULL;

		$this->db->where('userID', $id);
		if($this->db->delete('publicKeys')){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	// Get the profile message of a user id.
	public function get_profileMessage($userID){
		$this->db->where('id',$userID);
		$this->db->select('profileMessage');
		$query = $this->db->get('users');
		// Check if the profile message is set.
		if($query->num_rows() > 0 ){
			$result = $query->row_array();
			// Return the message
			return $result['profileMessage'];
		} else {
			// Otherwise return null.
			return NULL;
		}
	}

}
