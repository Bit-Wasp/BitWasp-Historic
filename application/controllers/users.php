<?php
class Users extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('my_captcha');
		$this->load->model('sessions_model');
		$this->load->model('users_model');
	}

	public function twoStep(){
		$this->load->library('form_validation');
		$data['title'] = 'Two Step Authentication';
		$data['page'] = 'users/twoStep';
		$userID = $this->my_session->userdata('id');

		// Check if the form has been submitted successfully.
		if($this->form_validation->run('twoStep') === TRUE){
	
			// Solution has been entered.
			$solution = $this->input->post('solution');

			// Check the solution against what's recorded in the DB.
			if($this->users_model->checkTwoStepChallenge($userID,$solution)){
				// Solution matches, load userinfo and create a full session.
				$loginInfo = $this->users_model->get_user(array('id' => $userID));
				$this->my_session->createSession($loginInfo);
                                redirect('home');

			} else {
				$data['returnMessage'] = "Your solution did not match the decrypted text. A new challenge has been generated.";

				// Solution does not match, show a new challenge.
				// Load users PGP fingerprint.
				$fingerprint = $this->users_model->get_pubKey_by_id($userID,1);
				// Generate a unique challenge for the user.
				$challenge = $this->general->uniqueHash('twoStep','twoStepChallenge');
				
				// Add the challenge to the DB.
				$this->users_model->addTwoStepChallenge($userID, $challenge);

				// Load GNUPG, add the users fingerprint, and encrypt the challenge text.
				$gpg = gnupg_init();
				gnupg_addencryptkey($gpg, $fingerprint);
				$string = gnupg_encrypt($gpg, "Two Step Token: $challenge\n");

				// Display the PGP text.
				$data['challenge'] = $string;
			}
			// Finish off session creation.
		} else {
			$fingerprint = $this->users_model->get_pubKey_by_id($userID, 1);
			$challenge = $this->general->uniqueHash('twoStep','twoStepChallenge');

			$this->users_model->addTwoStepChallenge($userID,$challenge);

			$gpg = gnupg_init();
			gnupg_addencryptkey($gpg, $fingerprint);
			$string = gnupg_encrypt($gpg, "Two Step Token: $challenge\n");

			$data['challenge'] = $string;

		}
		$this->load->library('layout',$data);
	}

	public function logoutInactivity() {
		// Check if the user is actually logged in - probably shouldn't happen by accident.
		if($this->my_session->userdata('logged_in') === TRUE)
			redirect('home');

		$this->load->library('form_validation');

		// Load the login page, advising the user they allowed the previous session to time out. 
		$data['title'] = 'Logout';
		$data['page'] = 'users/login';
		$data['captcha'] = $this->my_captcha->generateCaptcha();
		$data['returnMessage'] = "Your previous session has timed out due to inactivity, or you did not log out correctly. The old session has now timed out. Please log in again to continue.";
		$this->load->library('layout',$data);
	}

        public function view($userHash){
		$this->load->model('orders_model');
		// Load the user info from the database.
                $data['user'] = $this->users_model->get_user(array('userHash' => $userHash));

		//Load users public key from the databsae
		$data['user']['publicKey'] = $this->users_model->get_pubKey_by_id($data['user']['id']);

		// Check the entry exists.
		if($data['user'] !== null && $data['user'] !== false){
			// user exists
	                $data['title'] = $data['user']['userName'];
			$data['page'] = 'user/individual';

			$listReviews = array(	'reviewedID' => $data['user']['id'],
					 	'type' => 'Vendor',
						'count' => 5);

			$data['reviews'] = $this->orders_model->listReviews($listReviews);
	                $this->load->library('layout', $data);
			// Success; display the user information
		} else {
			redirect('error/userNotFound');
			// User not found, redirect to appropriate page.
	        }
	}

        function login() {
		// Check if user is already logged in
		if($this->my_session->userdata('logged_in') === TRUE)
			redirect('home');

                $this->load->helper(array('form', 'url'));
                $this->load->library('form_validation');

                if ($this->form_validation->run('login') == FALSE){
			// form not submitted, or unsuccessful
                        $data['title'] = 'Login';
			$data['page'] = 'users/login';
			$data['captcha'] = $this->my_captcha->generateCaptcha();
                } else  {
			// form submitted, check details are authentic

			// Set default to logged out
			$login = false;
			$twoStep = false;
			// Get id,userSalt, userHash, userRole from the DB.
			$getLoginInfo = $this->users_model->getLoginInfo(array('userName' =>$this->input->post('username')));
			// check the user exists
			if($getLoginInfo !== FALSE){
				// Encrypt the submitted password
				$salt = $getLoginInfo['userSalt'];
				$testpass = $this->general->hashFunction($this->input->post('password'),$salt);

				// Check whether the password matches that stored in the table.
				if($this->users_model->checkPass($this->input->post('username'),$testpass) === TRUE){
					if($getLoginInfo['twoStepAuth'] == '1'){
						$twoStep = true;
					} else {
						$login = true;
					}
				}
			}

			// Check whether the login is successul
			if($twoStep == true){
				$this->my_session->createSession($getLoginInfo, TRUE);	// TRUE, enables a half-session for twostep
				redirect('users/twoStep');
			} else	if($login == true){
				// Success
				$this->users_model->setLastLog($this->input->post('username'));
				$this->my_session->createSession($getLoginInfo);
 				redirect('home');
			} else {
	                        // submission unsuccessful
        	                $data['title'] = 'Login';
                        	$data['page'] = 'users/login'; 
				$data['returnMessage'] = "Your details were incorrect, try again.";
				$data['captcha'] = $this->my_captcha->generateCaptcha();

			}

                }
                $this->load->library('Layout',$data);
        }


	// Logout
	public function logout(){
		// Kill the session and redirect to the login page.
		$this->my_session->killSession($this->session->userdata('userHash'));
		redirect('users/login');
	}


	// Register function
	public function register(){
		// Check if the user is currently logged in.
		if($this->session->userdata('logged_in') == TRUE){
			redirect('home');
		} 

                $this->load->helper(array('form', 'url'));
                $this->load->library('form_validation');

		// Run form validation
                if ($this->form_validation->run('register') == FALSE){
			// Show the register form.
                        $data['title'] = 'Register';
                        $data['page'] = 'users/register'; 
                        $data['captcha'] = $this->my_captcha->generateCaptcha();
		} else {
			// Form validation successful

			// Generate the password
			$salt = $this->general->generateSalt();
			$hash = $this->general->hashFunction($this->input->post('password0'),$salt);
			
			// Determine the user role from the submitted value.
			$userRole = $this->find_role($this->input->post('usertype'));

			// Build the array for the model.
			$registerInfo = array(	'userName' => $this->input->post('username'),
						'password' => $hash,
						'timeRegistered' => time(),
						'userSalt' => $salt,
						'userHash' => $this->general->uniqueHash('users','userHash'),
						'userRole' => $userRole );						
			// Call addUser() function in the model to add the user.
			$register = $this->users_model->addUser($registerInfo);

			// Check the submission
			if($register){
				// Registration successful, show login page.
				$data['title'] = 'Registration Successful';
	                        $data['login'] = false;
				$data['returnMessage'] = 'Your account has been created, please login below.';
				$data['captcha'] = $this->my_captcha->generateCaptcha();
        	                $data['page'] = 'users/login'; 

			} else {
				// Unsuccessful submission, show form again.
                        	$data['title'] = 'Register';
				$data['returnMessage'] = 'Your registration was unsuccessful, please try again.';
        	                $data['page'] = 'users/register'; 
			}
		}
                $this->load->library('Layout',$data); 
	}

	// Return the role associated with the submitted role ID.
	public function find_role($roleId) {
		if($roleId==2) {
			return 'Vendor';
		} else {
			return 'Buyer';
		}			
	}

	// Callback functions

	// Check the captcha is correct.
	public function check_captcha($string){
		$result = $this->my_captcha->checkCode($string);
		return $result;
	}

	// Check the role is valid.
	public function register_check_role($role){
		if($role == '1' || $role == '2'){
			return TRUE;
		} else {
			return FALSE;
		}
	}




};
