<?php 

class Users_Model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
//		$this->load->library('user_session');
	}

	public function getLoginInfo($userName = FALSE){
		if($userName === FALSE){
			return NULL;
		} else {
			$this->db->select('userSalt, userHash, userRole');
			$query = $this->db->get_where('users', array('userName' => $userName));

			if($query->num_rows() > 0){
				return $query->row_array();
			} else {
				return false;
			}
		}
	}

	public function addUser($user, $pass, $salt, $hash){
		$userdata = array(	'userName' => $user,
					'password' => $pass,
					'timeRegistered' => time(),
					'userSalt' => $salt,
					'userHash' => $hash );
		$query = $this->db->insert('users',$userdata);
		if($query){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function setLastLog($username){
		$userdata = array('lastLog' => time());
		$this->db->where('username');
		$query = $this->db->insert('users',$userdata);
		if($query){
			return true;
		} else {
			return false;
		}
	}

	public function checkPass($username,$hash){
		$this->db->select('password');
		$query = $this->db->get_where('users', array(	'userName' => $username,
								'password' => $hash ));
		if($query->num_rows() > 0){
			return TRUE;
		} else {
			return FALSE;
		}
	}

}
