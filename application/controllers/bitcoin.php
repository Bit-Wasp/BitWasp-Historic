<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bitcoin extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$data['title'] = 'bitcoin';
		$data['page'] = 'home/index';
		$this->load->library('jsonrpcclient',array('url' => $this->my_config->bitcoinDURL()));

		$test = $this->jsonrpcclient->getinfo();
		$data['returnMessage'] .= "Received blocks: ".$test['blocks']."<br />";
		$test = $this->jsonrpcclient->getaccountaddress("1HB5XMLmzFVj8ALj6mfBsbifRoD4miY36v");
		$data['returnMessage'] .= "Received: $test\n";

		$this->load->library('layout',$data);
	}	

};
