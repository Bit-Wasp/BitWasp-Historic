<?php
class Sessions_Model extends CI_Model {

	public function __construct(){  
		$this->load->library('session');
	}

	// Get information from the sessions table by the userHash.
	public function getInfo($userHash){
		$this->db->select('last_activity');
		$query = $this->db->get_where('sessions',array('userHash' => $userHash));

		// If the session does not exist. 
		if($query->num_rows() == 0){
			// Create a new session.
			$this->createSession($userHash);
			
			// Query the DB again and get the new data.
			$query = $this->db->get_where('sessions',array('userHash' => $userHash));
		}
		
		// Return the results.
		return $query->row_array();

	}

	// Delete the session from the table.
	public function killSession($userHash){
		$query = $this->db->delete('sessions',array('userHash'=>$userHash));
		if($query){
			// Session removed, return TRUE.
			return TRUE;
		} else {
			// Failed, return FALSE.
			return FALSE;
		}
	}

	// Create a new session by the userHash.
	public function createSession($userHash){
		// Build a new session, insert it into the table.	
		$sessionData = array(	'userHash' => $userHash,
					'last_activity' => time() );

		$query = $this->db->insert('sessions',$sessionData);
		if($query){
			// Successfully entered into the table.
			return TRUE;
		} else {
			// Failed, return FALSE.
			return FALSE;
		}
	}

	// Store the session_id, userHash, and last activity.
	public function updateSession($userHash){
		// Build an array with the entries to update with.
		$sessionData = array( 	'session_id' => $this->session->userdata('session_id'),
					'userHash' => $userHash,
					'last_activity' => time() );

		$this->db->where('userHash',$userHash);
		$query = $this->db->update('sessions',$sessionData);
		if($query){
			// Successful; return TRUE.
			return TRUE;
		} else {
			// Failed, return FALSE.
			return FALSE;
		}
	}

};
?>
