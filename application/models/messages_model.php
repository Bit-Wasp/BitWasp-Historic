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

	public function getMessageByThread($threadHash, $count = FALSE){

		$query = $this->db->get_where('messages',array('threadHash'=>$threadHash));
		
		if($count==TRUE){
			return $this->db->count_all_results();
		} else {
			if($query->num_rows() > 0){
				return  $query->row_array();
			} else {
				return NULL;
			}
		}
	}

	public function getUnread($userID){
		$query = $this->db->get_where('messages',array('toId'=>$userID, 'viewed'=>0));
		if($query->num_rows() > 0){
			return $query->num_rows();
		} else {
			return 0;
		}
	}

	public function messages($userId){
		$this->load->model('users_model');
		$this->db->where('toId',$userId);
		$this->db->order_by('id DESC');
		$query = $this->db->get('messages');

		$array = array();
		if($query->num_rows() > 0){
			foreach($query->result() as $result){ //Loop through messages
				$fromUser = $this->users_model->get_user(array('id' => $result->fromId));
				array_push($array,array('id' =>	$result->id,
							'messageHash' => $result->messageHash,
							'fromUser' => $fromUser, //Return info about sender
							'subject' => $result->subject,
							'message' => $result->message,
							'viewed' => $result->viewed,
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

	public function deleteMessage($messageHash){
		//Delete message from the database
		$this->db->delete('messages', array('messageHash' => $messageHash));
		return TRUE;
	}

	//Update message when it is read
	public function setMessageViewed($messageID){
		$query = $this->db->where('id', $messageID);
		$query = $this->db->update('messages', array('viewed' => 1));
		if($query){
			return TRUE;
		} else {
			return FALSE;
		}
	}


};

