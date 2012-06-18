<?php

class Listings extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('my_session'); 			// restrict to vendors only
		$this->load->model('user_model');
		$this->load->model('products_model');
		$this->load->model('listings_model');
//		$this->load->models('');
	}

	public function index(){
                $this->my_session->checkAuth('vendor');
		$data['title'] = 'My Listings';
		$data['page'] = 'listings/index';

		$this->load->library('layout',$data);
	}


};



