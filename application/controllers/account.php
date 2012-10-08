<?php

class Account extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('users_model');
		$this->load->model('accounts_model');
		$this->load->library('form_validation');
	}

	public function index(){
		$data['page'] = 'account/index';
		$data['title'] = 'My Account';
		$userHash = $this->my_session->userdata('userHash');
		$data['account'] = $this->accounts_model->getAccountInfo($userHash);
		
		$this->load->library('layout',$data);
	}

	public function edit(){
		$userHash = $this->my_session->userdata('userHash');

		$data['page'] = 'account/edit';
		$data['title'] = 'Edit Account';

		$data['account'] = $this->accounts_model->getAccountInfo($userHash);
		$this->load->library('layout',$data);
	} 

	public function update(){
		// Load information about the current user
		$userHash = $this->my_session->userdata('userHash');
		$loginInfo = $this->users_model->get_user(array('userHash' => $userHash));
		// Generate the hash of the password to test.
		$testPass = $this->general->hashFunction($this->input->post('passwordConfirm'),$loginInfo['userSalt']);	

		// Check the password for this username.
		$checkPass = $this->users_model->checkPass($loginInfo['userName'], $testPass);
		if($checkPass === TRUE){
			// Password correct
			$correctPass = TRUE;
		} else {
			// Password incorrect, stop code execution later.
			$correctPass = FALSE;
		}

		// Check if there's a problem with the submitted PGP key.
		$PGPfail = FALSE;
		$pubKey = $this->input->post('pubKey',TRUE);
		$changes = array();

		// Check if the public Key is set.
		if(	$this->input->post('pubKey') !== 'No Public Key found.' &&
			$this->input->post('pubKey') !== NULL ){
			// Load the sumitee
			$currentKey = $this->users_model->get_pubKey_by_id($loginInfo['id']);
			// Check if the current Key is empty
			if($currentKey === NULL){
				// Check the submission is not empty (in that case, do nothing).
				if($pubKey !== NULL){
					// Check the PGP Key is OK!
					if(substr($pubKey,0,36) == '-----BEGIN PGP PUBLIC KEY BLOCK-----'){
						// Add to the changes array.
						$changes['pubKey'] = $pubKey;
					} else {
						// Got this far, but there was a problem. Incorrect heading.
						$PGPfail = TRUE;
					}
				}
			// Check if there is currently a public Key.
			} else if(substr($currentKey,0,36) == 'BEGIN PGP PUBLIC KEY BLOCK-----'){

				// Check the POST data is also a PGP key, and that it's different to the current one. 
				if((substr($pubKey,0,36) == '-----BEGIN PGP PUBLIC KEY BLOCK-----') &&
				(sha2($pubKey) !== sha2($currentKey))){
					// New one is different, make the change!
					$changes['pubKey'] = $pubKey;
				} else if(substr($pubKey,0,36) !== '-----BEGIN PGP PUBLIC KEY BLOCK-----' &&
					$pubKey !== NULL){
					// Heading is invalid!
					$PGPfail = TRUE;
				}	
				// Do nothing if pubKey is empty. 
			}				
		}

		$twoStep = $this->input->post('twoStep');
		if($twoStep !== $loginInfo['twoStepAuth']){
			$changes['twoStep'] = $twoStep;
		}

		$forcePGPmessage = $this->input->post('forcePGPmessage');
		if($forcePGPmessage !== $loginInfo['forcePGPmessage']){
			$changes['forcePGPmessage'] = $forcePGPmessage;
		}

		$passFail = FALSE;
		// Check if we are suppposed to update the password.
		if(	strlen($this->input->post('password0') > 0)){
			// Check the two passwords match.
			if($this->input->post('password0') == $this->input->post('password1')){
				$changes['password'] = $this->general->hashFunction($this->input->post('password0'),$loginInfo['userSalt']);
			} else {
				// Passwords don't match.
				$passFail = TRUE;
			}
		}


		$currentMessage = $this->users_model->get_profileMessage($loginInfo['id']);
		$newMessage = strip_tags(nl2br($this->input->post('profileMessage',TRUE)),'<br>');
		if($currentMessage !== $newMessage){
			$changes['profileMessage'] = $newMessage;
		}

		$error = FALSE;
		$errorMsg = "";
		// Check that the user has submitted the right password.
		if($PGPfail === TRUE){
			$error = TRUE;		// ERROR!
			$errorMsg .= "Please check your PGP Key.<br />";
		// Check if the passwords don't match.
		} else if($passFail === TRUE){
			$error = TRUE;		// ERROR!
			$errorMsg .= "Your passwords do not match.<br />";
		}

		if($correctPass === FALSE){
			$data['page'] = 'account/edit';
			$data['title'] = 'Edit Account';
                        $data['returnMessage'] = "Your password was incorrect, please try again.";
		} else if($error === TRUE){
			// Display the edit form.
			$data['page'] = 'account/edit';
			$data['title'] = 'Edit Account';
			$data['returnMessage'] = $errorMsg;
		} else {
			// No errors! Update the account.
			if($this->accounts_model->updateAccount($loginInfo['id'],$changes) == TRUE){
				// Success; display the account page.
				$data['page'] = 'account/index';
				$data['title'] = 'Account';
				$data['returnMessage'] = 'Account has been updated.';
			} else {
				// Otherwise, display the edit page.
				$data['page'] = 'account/edit';
				$data['title'] = 'Edit Account';
				$data['returnMessage'] = "Something went wrong, please try again.";
			}
		}
		
		// Load account info.
		$data['account'] = $this->accounts_model->getAccountInfo($userHash);
		$this->load->library('layout',$data);
	}

	// Delete the stored pubKey for the user, and disable two-step authentication if necessary.
	public function deletePubKey(){
		$userHash = $this->my_session->userdata('userHash');
		
		$user = $this->users_model->get_user(array('userHash' => $userHash));
		// Load the public key for the current user.
		$pubKey = $this->users_model->get_pubKey_by_id($user['id']);

		// Check if there is a PGP on record.
		if($pubKey == NULL){
			// Failure; no PGP key to delete.
			$data['page'] = "account/index";
			$data['title'] = "Account";
			$data['returnMessage'] = "You do not have a PGP key on record.";
		} else {
			// There is a PGP key, try delete it.
			if($this->users_model->drop_pubKey_by_id($user['id'])){
				// Success, display the account page.
				$data['page'] = "account/index";
				$data['title'] = "Account";
				$data['returnMessage'] = "Your PGP key has been erased.";
			} else {
				// Failure, show the accout page.
				$data['page'] = "account/index";
				$data['title'] = "Account";
				$data['returnMessage'] = "There was an error deleting your PGP key.";
			}
		}

		// Load account info for the user.
		$data['account'] = $this->accounts_model->getAccountInfo($userHash);

		$this->load->library('layout',$data);
	}
};

