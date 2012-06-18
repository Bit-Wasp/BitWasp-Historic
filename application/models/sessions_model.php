<?php
class Sessions_Model extends CI_Model {

	public function __construct(){  
		$this->load->library('session');
	}


	public function getInfo($userHash){
		$this->db->select('last_activity');
		$query = $this->db->get_where('sessions',array('userHash' => $userHash));
		if($query->num_rows() == 0){
			$this->createSession($userHash);
			$query = $this->db->get_where('sessions',array('userHash' => $userHash));
		}
		
		return $query->row_array();

	}

	public function killSession($userHash){
		$query = $this->db->delete('sessions',array('userHash'=>$userHash));
		if($query){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function createSession($userHash){
		$sessionData = array(	'userHash' => $userHash,
					'last_activity' => time() );
		$query = $this->db->insert('sessions',$sessionData);
		if($query){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function updateSession($userHash){
		$sessionData = array( 	'session_id' => $this->session->userdata('session_id'),
					'userHash' => $userHash,
					'last_activity' => time() );
		$this->db->where('userHash',$userHash);
		$query = $this->db->update('sessions',$sessionData);
		if($query){
			return TRUE;
		} else {
			return FALSE;
		}
	}

};
?>
