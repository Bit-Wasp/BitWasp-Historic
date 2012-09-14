<?php 

class My_config {

	public $site_title = '';

	public $login_timeout = '';

	public $base_url = '';

	public $index_page = '';

	public function __construct(){
		$CI = &get_instance();
		
		$CI->load->model('general_model');

		$config = $CI->general_model->siteConfig();

		$this->site_title = $config->site_title;
		$this->login_timeout = $config->login_timeout;
		$this->base_url = $config->base_url;
		$this->index_page = $config->index_page;

		$CI->config->set_item('base_url', $this->base_url);
		$CI->config->set_item('index_page', $this->index_page);

	}

	public function loadAll(){
		$results = array(	'site_title' => $this->site_title,
					'login_timeout' => $this->login_timeout,
					'base_url' => $this->base_url,
					'index_page' => $this->index_page );
		return $results;
	}

	public function site_title(){
		return $this->site_title;
	}

	public function login_timeout(){
		return $this->login_timeout;
	}

};

