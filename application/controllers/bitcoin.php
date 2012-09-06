<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bitcoin extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$data['title'] = 'bitcoin';
		$data['page'] = 'home/index';
		$this->load->library('jsonrpcclient',array('url' => 'http://user:passJ2xHL0su3@127.0.0.1:8332'));
		print_r($this->jsonrpcclient->getinfo();
//		$bitcoin = new jsonRPCClient('http://user:passJ2xHL0su3@127.0.0.1:8332/');
		
		$this->load->library('layout',$data);
	}	

};
