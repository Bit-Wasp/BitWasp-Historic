<?php

class User extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
                $this->load->model('users_model');
		$this->load->library('my_session');
//		$data
//                $this->users_model->checkSession();
	}

        public function view($userHash){
		// Check the user is at least logged in
		$this->my_session->checkAuth('login');

                $data['user'] = $this->user_model->get_user($userHash);
		if($data['user'] !== null && $data['user'] !== false){
			// user exists
	                $data['title'] = $data['user']['userName'];
			$data['page'] = 'user/individual';
			$data['login'] = 'true';
	                $this->load->library('layout', $data);
		} else {
			$data['title'] = 'User not found';
			$data['page'] = 'user/notFound';
			$data['login'] = 'true';
			$this->load->library('layout', $data);
	        }
	}
};

