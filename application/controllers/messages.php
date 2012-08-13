<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Messages extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('my_session');
		$this->load->model('messages_model');
		$this->load->model('users_model');
	}

	public function inbox(){

		$data['title'] = 'Inbox';
		$data['page'] = 'messages/inbox';
		$userId = $this->my_session->userdata('id');
		$data['messages'] = $this->messages_model->messages($userId);
		if($data['messages'] === NULL)
			$data['returnMessage'] = 'You have no messages in your inbox';
		
		$this->load->library('layout',$data);
	}

	public function read($messageHash){
		$messageInfo = $this->messages_model->getMessage($messageHash); //Look up the requested message
		if($messageInfo === NULL){  //Display an error if there is no matching message
			$data['title'] = 'Inbox';
			$data['page'] = 'messages/inbox';
			$data['returnMessage'] = 'This message cannot be found.';
			$userId = $this->my_session->userdata('id');
			$data['messages'] = $this->messages_model->messages($userId);

			if($data['messages'] === NULL)
				$data['returnMessage'] .= 'You have no messages in your inbox';
		
		} else { //There is matching messages, begin outputting
			if($this->my_session->userdata('id') == $messageInfo['toId'] ||
			   $this->my_session->userdata('id') == $messageInfo['fromId'] ){ //Show messages from or too the current user.
				$this->load->library('form_validation');
			
				$data['title'] = substr($messageInfo['subject'], 0, 40).'...';	
				$data['page'] = 'messages/read';

				$data['fromUser'] = $this->users_model->get_user_by_id($messageInfo['fromId']);
				$data['subject'] = $messageInfo['subject'];
				$data['message'] = $messageInfo['message'];	
			
				if($messageInfo['encrypted']==1){ $data['isEncrypted']=1; } else { $data['isEncrypted'] = 0; } //Check if message is encrypted.

			} else { //Otherwise the user should not be able to view this message
				$data['title'] = 'Inbox';	
				$data['page'] = 'messages/inbox';
				$data['returnMessage'] = 'Not authorized to view this message.';
				$userHash = $this->my_session->userdata('userHash');
				$data['messages'] = $this->messages_model->messages($userHash);
				if($data['messages'] === NULL)
					$data['returnMessage'] .= 'You have no messages in your inbox';
			}
		}
		$this->load->library('layout',$data);
	}

	public function send($toHash = NULL){
		//Include the required files for clientside encryption
		$data['header_meta'] = $this->load->view('messages/encryptionHeader', NULL, true);
		$data['returnMessage'] = '';
	
		$this->load->library('form_validation');
		$data['title'] = 'Send Message';
		$data['page'] = 'messages/send';
	
		//Check if the provided user hash matches a user.
		if($toHash !== NULL){ //A user was specified
			$recipient = $this->users_model->get_user($toHash);
			if($recipient['userName'] === NULL){ //Check if a user is found with the specified userHash
				$data['returnMessage'] = 'The requested user could not be found.';
				$data['to'] = '';
			} else { //A matching user was found.
				$data['to'] = $recipient['userName'];
			}
		} else { //If no user was specified try use the submitted value
			$data['to'] = $this->input->post('recipient');
		}

		$recipient = $this->users_model->get_user_by_name($data['to']);
		$data['publickey'] = $this->users_model->get_pubKey_by_id($recipient['id']);
		if($data['publickey']!=''){ $data['returnMessage'] .= 'This message will be encrypted automatically if you have javascript enabled.<br />';  }

		//Need to check if provided username is valid
                if ($this->form_validation->run('sendmessage') == FALSE){
			//Submitted form didn't pass validation

                } else  {
			//Add message to database
			if($recipient!==FALSE){ //Check if recipient is found.

				if ('-----BEGIN' !== FALSE) { //Check if the message appears to be encrypted.
				    $isEncrypted = 1;
				} else {  $isEncrypted = 0; }

				$messageHash = $this->general->uniqueHash('messages','messageHash');

				$messageArray = array(  'toId' => $recipient['id'],
				        'fromId' => $this->my_session->userdata('id'),
				        'messageHash' => $messageHash,
					'orderID' => 0,
					'subject' => $this->input->post('subject'),
					'message' => $this->input->post('message'),
					'encrypted' => 0,
					'time' => time());

				$this->messages_model->addMessage($messageArray);

				$data['returnMessage'] = 'Message has been sent.';
				$data['title'] = 'Message Sent';
			        $data['page'] = 'messages/inbox'; 
			}
                }
                $this->load->library('Layout',$data);

	}


};
