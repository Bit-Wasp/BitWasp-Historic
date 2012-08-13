<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$data['title'] = 'Home';
		$data['page'] = 'home/index';
		$this->load->library('layout',$data);

	}

};

