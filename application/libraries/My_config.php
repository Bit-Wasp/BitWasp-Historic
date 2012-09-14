<?php 

class My_config {

	public $site_title = '';

	public $login_timeout = '';

	public function __construct(){
		$CI = &get_instance();
		
		$CI->load->model('general_model');

		$config = $CI->general_model->siteConfig();

		$this->site_title = $config->site_title;
		$this->login_timeout = $config->login_timeout;
		$this->base_url = $config->base_url;

		$CI->config->set_item('base_url', $this->base_url);

	}

	public function loadAll(){
		$results = array(	'site_title' => $this->site_title,
					'login_timeout' => $this->login_timeout,
					'base_url' => $this->base_url );
		return $results;
	}

	public function site_title(){
		return $this->site_title;
	}

	public function login_timeout(){
		return $this->login_timeout;
	}

};

