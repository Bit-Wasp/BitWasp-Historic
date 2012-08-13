<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {

	public function __construct() {  
		parent::__construct();
	}

	public function view($page = 'home'){
		$this->load->model('pages_model');
		$data['page'] = $this->pages_model->get_page($page);

		//Check if this page exists
		if ($data['page']==NULL)
		{
			// Whoops, we don't have a page for that!
			show_404();
		} else {
		
		$data['title'] = $data['page']['title']; //Display page title
		$data['content'] = $data['page']['content']; //Display page title
		$data['page'] = $page;
		$this->load->library('layout',$data);
		}
	}
}
