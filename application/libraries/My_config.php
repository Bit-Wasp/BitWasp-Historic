<?php 

class My_config {

	// Initialize the class variables
	public $site_title = '';
	public $login_timeout = '';
	public $base_url = '';
	public $index_page = '';
	public $items_per_page = '';
	public $registration_allowed = '';
	public $force_vendor_PGP = '';
	public $catpcha_length = '';

	public function __construct(){
		$CI = &get_instance();
		
		$CI->load->model('general_model');

		// Load the site configuration
		$config = $CI->general_model->siteConfig();

		// Set the object variables with the sites configuration
		$this->site_title = $config->site_title;
		$this->login_timeout = $config->login_timeout;
		$this->base_url = $config->base_url;
		$this->index_page = $config->index_page;
		$this->registration_allowed = $config->registration_allowed;
		$this->force_vendor_PGP = $config->force_vendor_PGP;
		$this->captcha_length = $config->captcha_length;

		// Load the number of items to display.
		if($CI->session->userdata('items_per_page')){
			$this->items_per_page = $CI->session->userdata('items_per_page');
		} else {
			$this->items_per_page = '25';
		}

		// Have CodeIgniter take the values in the table as the base_url and index_page
		$CI->config->set_item('base_url', $this->base_url);
		$CI->config->set_item('index_page', $this->index_page);
	}

	public function loadAll(){
		return get_object_vars($this);
	}

	public function items_per_page(){
		return $this->items_per_page;
	}

	public function site_title(){
		return $this->site_title;
	}

	public function login_timeout(){
		return $this->login_timeout;
	}

	public function registration_allowed(){
		return $this->registration_allowed;
	}

	public function force_vendor_PGP(){
		return $this->force_vendor_PGP;
	}

	public function captcha_length(){
		return $this->captcha_length;
	}

};

