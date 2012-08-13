<?php

class Messages_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->library('my_session');
	}

	public function getMessage($messageHash){
		$query = $this->db->get_where('messages',array('messageHash'=>$messageHash));
		if($query->num_rows() > 0){
			return  $query->row_array();
		} else {
			return NULL;
		}
	}

	public function messages($userId){
		$this->load->model('users_model');
		$this->db->where('toId',$userId);
		$query = $this->db->get('messages');

		$array = array();
		if($query->num_rows() > 0){
			foreach($query->result() as $result){ //Loop through messages
				$fromUser = $this->users_model->get_user_by_id($result->fromId);
				array_push($array,array('id' =>	$result->id,
							'messageHash' => $result->messageHash,
							'fromUser' => $this->users_model->get_user_by_id($result->fromId), //Return info about sender
							'subject' => $result->subject,
							'message' => $result->message,
							'time' => $result->time ));
			}

			return $array;
		} else {
			return NULL;
		}
	}



	public function addMessage($messageArray){
		$query = $this->db->insert('messages',$messageArray);
		if($query){
			return TRUE;
		} else {
			return FALSE;
		}
	}

};


