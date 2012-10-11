<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Items extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('items_model');
		$this->load->model('users_model');
		$this->load->model('categories_model');
		$this->load->library('my_image');
		$this->load->library('pagination');
	}

	// View item listings
	// URI: items
	// Auth: Login
	public function index()	{

		//Load the latest items, default is 20.
		$data['title'] = 'Items';
		$data['page'] = 'items/index';
		
	        $config = array();
	        $config["base_url"] = site_url() . "/items";
	        $config["total_rows"] = $this->items_model->get_items_count();
	        $config["per_page"] = $this->my_config->items_per_page();
	        $config["uri_segment"] = 2;

	        $this->pagination->initialize($config);


	        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

		$data['items'] = $this->items_model->getLatest($config["per_page"], $page);

		$data['pagination_links'] = $this->pagination->create_links();

		//Check if there are no matching items
		if(empty($data['items'])){
			$data['returnMessage'] = "No matching items have been found. Please return soon.";
		}
		$this->load->library('layout',$data);
	}


	// View individual item
	// URI: item/
	// Auth: Login
	public function view($itemHash){
		$data['item'] = $this->items_model->get_items($itemHash);

		//Check if item exists
		if ($data['item']==NULL)
		{
			$data['title'] = 'Not Found';
			$data['returnMessage'] = 'That item cannot be found.';
			$data['page'] = 'items/index';
		
		        $config = array();
		        $config["base_url"] = site_url() . "/items";
		        $config["total_rows"] = $this->items_model->get_items_count();
		        $config["per_page"] = 20;
		        $config["uri_segment"] = 2;	
			$choice = $config["total_rows"] / $config["per_page"];
			$config["num_links"] = round($choice);
		        $this->pagination->initialize($config);

			$page = 0;
			
			$data['items'] = $this->items_model->getLatest($config["per_page"], $page);
			$data['pagination_links'] = $this->pagination->create_links();		

		} else {
			$this->load->model('orders_model');

			$data['userRole'] = strtolower($this->my_session->userdata('userRole'));
			$data['title'] = $data['item']['name'];
/*
			$listReviews = array(	'reviewedID' => $data['item']['id'],
						'type' => 'Item',
						'count' => 5);	

			$data['reviews'] = $this->orders_model->listReviews($listReviews);*/
			$data['page'] = 'items/individual';
		}

		$this->load->library('layout',$data);
	}

	// View category page and show sub items
	// URI: cat/
	// Auth: Login
	public function cat($catID = FALSE){
		$config["per_page"] = $this->my_config->items_per_page(); 

		//Load information about current category
		$data['category'] = $this->categories_model->catInfo($catID);
    		$data['currentCat'] = $data['category']; //Store category information persistantly
		$data['total_rows'] = $this->categories_model->get_catItems_count($catID);

		
		//Check if category exists
		if ($data['category']==NULL)
		{
		        $config["base_url"] = site_url() . "/items";
		        $config["total_rows"] = $this->items_model->get_items_count();
		        $config["uri_segment"] = 2;
			$choice = $config["total_rows"] / $config["per_page"];
			$config["num_links"] = round($choice);
		        $this->pagination->initialize($config);

			$page = 0;

			$data['title'] = "Not Found";
			$data['page'] = 'items/index';
			$data['returnMessage'] = "The category you requested was not found.";
			$data['pagination_links'] = $this->pagination->create_links();
			$data['items'] = $this->items_model->getLatest($config["per_page"], $page);		// Whoops, we don't have that category


		} elseif($data['total_rows'] > 0){ 

		        $config = array();
		        $config["base_url"] = site_url() . "/cat/$catID";
		        $config["total_rows"] = $this->categories_model->get_catItems_count($catID);
		        $config["uri_segment"] = 3;
			$choice = $config["total_rows"] / $config["per_page"];
			$config["num_links"] = round($choice);
		        $this->pagination->initialize($config);
	
		        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$data['title'] = $data['category']['name'];
			$data['page'] = 'items/index';
			$data['items'] = $this->categories_model->getCatItems($config['per_page'], $page, $catID);
			$data['pagination_links'] = $this->pagination->create_links();

		} else {
	
		        $config["base_url"] = site_url() . "/items";
		        $config["total_rows"] = $this->items_model->get_items_count();
		        $config["uri_segment"] = 2;
			$choice = $config["total_rows"] / $config["per_page"];
			$config["num_links"] = round($choice);
		        $this->pagination->initialize($config);

			$page = 0;
			$data['title'] = $data['category']['name'];
			$data['page'] = 'items/index';
			$data['returnMessage'] = "The category you requested is empty.";
			$data['pagination_links'] = $this->pagination->create_links();
			$data['items'] = $this->items_model->getLatest($config["per_page"], $page);		// Whoops, we don't have that category
		}
		$this->load->library('layout',$data);
	}

	// Callback functions, 

	// Check the category exists.
	public function check_category_exists($id){
		return  $this->categories_model->checkCategoryExists($id);
	}

}
