<?php
session_start();

class Users extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('my_session');
		$this->load->model('sessions_model');
		$this->load->model('users_model');
		$this->load->library('my_captcha');
	}

	function logoutInactivity() {
		if($this->my_session->userdata('logged_in') === TRUE)
			redirect('products');

		$data['title'] = 'Logout';
		$data['page'] = 'users/logoutInactivity';
		$this->load->library('layout',$data);
	}

        function index() {
		// Check if user is already logged in
		if($this->my_session->userdata('logged_in') === TRUE)
			redirect('products');

                $this->load->helper(array('form', 'url'));
                $this->load->library('form_validation');

                if ($this->form_validation->run('login') == FALSE){

			// form not submitted, or unsuccessful
                        $data['title'] = 'Login';
			$data['page'] = 'users/login';
			$data['captcha'] = $this->my_captcha->generateCaptcha();
	                $this->load->library('Layout',$data);

                } else  {
			// form submitted, check details are authentic

			// Set default to logged out
			$login = false;

			$getLoginInfo = $this->users_model->getLoginInfo($this->input->post('username'));
			// check the user exists
			if(count($getLoginInfo) > 0){
				$salt = $getLoginInfo['userSalt'];
				$testpass = $this->hashFunction($this->input->post('password'),$salt);
				if($this->users_model->checkPass($this->input->post('username'),$testpass) === TRUE){
					$login = true;
				}
			}

			if($login == true){
					$this->users_model->setLastLog($this->input->post('username'));
					$this->my_session->createSession($getLoginInfo);
                                        redirect('products');
			} else {
	                        // submission unsuccessful
        	                $data['title'] = 'Login';
                        	$data['page'] = 'users/loginTryAgain'; 
				$data['captcha'] = $this->my_captcha->generateCaptcha();
                       		$this->load->library('Layout',$data); 

			}

                }
        }

	public function check_captcha($string){
		if($this->my_captcha->checkCode($string)){
			return true;
		} else {
			return false;
		}
	}

	public function logout(){
		$this->my_session->killSession($this->session->userdata('userHash'));
		redirect('users/login');
	}

	public function register_check_role($role){
		if($role == '1' || $role == '2'){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function generateSalt(){
		$rand = rand(12,24);
		$salt = "";
		for($i = 0; $i < $rand; $i++){
			$salt.= chr(rand(97,125));
		}
		return $salt;
	}

	public function register(){
		if($this->session->userdata('logged_in') == TRUE){
			redirect('products');
		} 

                $this->load->helper(array('form', 'url'));
                $this->load->library('form_validation');

                if ($this->form_validation->run('register') == FALSE){

                        $data['title'] = 'Register';
                        $data['page'] = 'users/register'; 
                        $data['captcha'] = $this->my_captcha->generateCaptcha();
                        $this->load->library('Layout',$data); 

		} else {
			$salt = $this->generateSalt();
			$pass = $this->hashFunction($this->input->post('password0'),$salt);
			$hash = substr($this->hashFunction($this->generateSalt(),$this->generateSalt()),0,16);

			// (userName, password, timeRegistered, userHash, userSalt>
			$register = $this->users_model->addUser(	
							$this->input->post('username'),
							$pass,
							$salt,
							$hash 
						);

			if($register){
				$data['title'] = 'Registration Successful';
	                        $data['login'] = false;
        	                $data['page'] = 'users/registerSuccess'; 
                	        $this->load->library('Layout',$data); 

			} else {

                        	$data['title'] = 'Register';
        	                $data['page'] = 'users/registerTryAgain'; 
	                        $this->load->library('Layout',$data); 

			}
		}
	}



        public function hashFunction($pass,$salt){
                return hash('sha256',$pass.hash('sha256',$salt));
        }

};
