<?php

class Messages_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->library('my_session');
	}

	// Load a message as specified by the hash.
	public function getMessage($messageHash){
		// Run the query.
		$query = $this->db->get_where('messages',array('messageHash'=>$messageHash));
		if($query->num_rows() > 0){
			// If the query returned results, return them.
			return  $query->row_array();
		} else {
			// Otherwise return NULL.
			return NULL;
		}
	}

	// Load messages by a thread hash, or load the number of messages in a thread.
	public function getMessageByThread($threadHash, $count = FALSE){

		// Load messages by thread hash.
		$query = $this->db->get_where('messages',array('threadHash'=>$threadHash));
		
		// If we're only looking for the number of messages in a thread.
		if($count==TRUE){
			// Return the number of results.
			return $this->db->count_all_results();
		} else {
		        // Check there are results to the query.
		        if($query->num_rows() > 0){
		                $array = array();
			        // Loop through each message, and build up an array of results.
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

			        // Return results array.
			        return $array;
		        } else {
			        // Otherwise return NULL.
			        return NULL;
			}
		}
	}

	// Load unread messages by recipient userID.
	public function getUnread($userID){
		// Load messages from the table.
		$query = $this->db->get_where('messages',array('toId'=>$userID, 'viewed'=>0));

		// Check there are results to the query
		if($query->num_rows() > 0){
			// Return rseults
			return $query->num_rows();
		} else {
			// Otherwise return 0.
			return 0;
		}
	}

	// Load all messages by recipient ID.
	public function messages($userId){
		// Load messages
		$this->load->model('users_model');
		$this->db->where('toId',$userId);
		$this->db->order_by('id DESC');
		$query = $this->db->get('messages');

		$array = array();
		// Check there are results to the query.
		if($query->num_rows() > 0){
			// Loop through each message, and build up an array of results.
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

			// Return results array.
			return $array;
		} else {
			// Otherwise return NULL.
			return NULL;
		}
	}

	// Insert a message into the table.
	public function addMessage($messageArray){
		$query = $this->db->insert('messages',$messageArray);
		if($query){
			// If the message was added, return TRUE.
			return TRUE;
		} else {
			// Otherwise, return FALSE.
			return FALSE;
		}
	}

	// Delete a message, as specified by the messageHash.
	public function deleteMessage($messageHash){
		//Delete message from the database
		if($this->db->delete('messages', array('messageHash' => $messageHash))){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	//Update message when it is read
	public function setMessageViewed($messageID){
		// Select a message to update, and update the table. 
		$query = $this->db->where('id', $messageID);
		$query = $this->db->update('messages', array('viewed' => 1));
		if($query){
			// Successful; return TRUE.
			return TRUE;
		} else {
			// Failed, return FALSE.
			return FALSE;
		}
	}


};

