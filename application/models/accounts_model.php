<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts_model extends CI_Model {

	public function __construct(){	
		$this->load->model('users_model');
	}

	// Load account information into an array
	public function getAccountInfo($userHash){
		// Load the user by the userhash.
		$user = $this->users_model->get_user(array('userHash' => $userHash));

		// Load the users public key and fingerprint
		$pubKey = $this->users_model->get_pubKey_by_id($user['id']);
		$fingerprint = $this->users_model->get_pubKey_by_id($user['id'],true);

		if($pubKey === NULL){
			// No public key on record
			$pubKey = "No Public Key found.";
			$fingerprint = NULL;
			$dispFingerprint = NULL;
		} else if($fingerprint !== NULL){
			$dispFingerprint = substr($fingerprint,0,31).'<strong>'.substr($fingerprint,32).'</strong>';
		}

		// Compile the results into an array
		$results = array(	'userName' => $user['userName'],
					'userHash' => $user['userHash'],
					'userRole' => $user['userRole'],
					'pubKey'   => $pubKey,
					'pubKeyFingerprint' => $fingerprint,
					'displayFingerprint' => $dispFingerprint,
					'twoStepAuth' => $user['twoStepAuth'],
					'forcePGPmessage' => $user['forcePGPmessage'],
					'profileMessage' => $user['profileMessage'],
					'items_per_page' => $user['items_per_page'] );
		return $results;
	}

	// Update the users account
	public function updateAccount($userID, $changes){

		// Check if there is something to do!
		if(count($changes) > 0){

			// Load the names for the indexes in the array
			$keys = array_keys($changes);
			$count = 0;
			$results = array();

			foreach($keys as $key){

				// Check if the public key is meant to be changed.
	                        if($key == 'pubKey'){

					// Initialize GnuPG
	                                $gpg = gnupg_init();

					// Import the public key, return information about the import and key.
	                                $keyInfo = gnupg_import($gpg,$changes['pubKey']);

					// If import fails, the fingerprint array is unset. 
					// Check that the key is valid.
					if(isset($keyInfo['fingerprint'])){

						// Check if there is already a public key.
		                                $checkPrev = $this->db->get_where('publicKeys', array('userID'=>$userID));
		                                if($checkPrev->num_rows() > 0){

							// Update the public key if there is one already
		                                        $this->db->where('userID',$userID);
		
		                                        $update = array('key' => $changes['pubKey'],
		                                                        'fingerprint' => $keyInfo['fingerprint']);

							// Set a return value for the entry
		                                        if($this->db->update('publicKeys', $update) === TRUE){
		                                                $result['pubKey'] = true;
		                                        } else {
		                                                $result['pubKey'] = false;
		                                        }
		                                } else {
		
							// Otherwise, add the new public key.
		                                        $update = array('key' => $changes['pubKey'],
		                                                        'userID' => $userID,
		                                                        'fingerprint' => $keyInfo['fingerprint']);
		                                        if($this->db->insert('publicKeys',$update)){
		                                                $result['pubKey'] = true;
		                                        } else {
		                                                $result['pubKey'] = false;
		                                        }
		                                }
					} else {	
						// Key was invalid, return false.
						$result['pubKey'] = false;
					}
	                        } 

				// Check if the password is to be updated.
	                       if($key == 'password'){
					// Update the password by the userID.
	                                $this->db->where('id',$userID);
	                                $update = array('password' => $changes['password']);

					// Set a return value for the entry.
	                                if($this->db->update('users',$update)){
	                                        $result['password'] = true;
	                                } else {
	                                        $result['password'] = false;
	                                }
	                        }
				
				// Check if two step login is being enabled/disabled.
				if($key == 'twoStep'){
					// Update the entry
					$this->db->where('id',$userID);
					$update = array('twoStepAuth' => $changes['twoStep']);

					// Set a return value.
					if($this->db->update('users',$update)){
						$result['twoStep'] = true;
					} else {
						$result['twoStep'] = false;
					}
				}

				// Check if forced PGP messaging is being set/unset
				if($key == 'forcePGPmessage'){
					$this->db->where('id',$userID);
					$update = array('forcePGPmessage' => $changes['forcePGPmessage']);

					// Set a return value.
					if($this->db->update('users',$update)){
						$result['forcePGPmessage'] = true;
					} else {
						$result['forcePGPmessage'] = false;
					}
				}

				// Check if the profile message is being updated.
				if($key == 'profileMessage'){
					$this->db->where('id',$userID);
					$update = array('profileMessage' => nl2br($changes['profileMessage']));
					// Set a return value.
					if($this->db->update('users',$update)){
						$result['profileMessage'] = true;
					} else {
						$result['profileMessage'] = false;
					}
				}

				// Check if the default items to show per page is being updated.
				if($key == 'items_per_page'){
					$this->db->where('id',$userID);
					$update = array('items_per_page' => $changes['items_per_page']);
					// Update the entry, and set a return value. 
					if($this->db->update('users',$update)){
						$result['items_per_page'] = true;
					} else {
						$result['items_per_page'] = false;
					}
				}

			}

			// Set the default return value.
			$returnVal = TRUE;
			// Loop through response codes and see if any were false.
			foreach($result as $test){
				if($test == false)
					$returnVal = FALSE;
			}

			// Return true, if every update was successful. If one or more was unsuccessful, return false;
			return $returnVal;
		} else {
			// Return NULL if there are no changes.
			return NULL;
		}
	}
};
