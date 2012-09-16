<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Items extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('items_model');
		$this->load->model('users_model');
		$this->load->model('categories_model');
		$this->load->library('my_image');
	}

	// View item listings
	// URI: items
	// Auth: Login
	public function index()	{
		//Load the latest items, default is 20.
		$data['title'] = 'Items';
		$data['page'] = 'items/index';
		$data['items'] = $this->items_model->getLatest();
		
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
			$data['items'] = $this->items_model->getLatest();
			$data['page'] = 'items/index';
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

		//Load information about current category
		$data['category'] = $this->categories_model->catInfo($catID);
    $data['currentCat'] = $data['category']; //Store category information persistantly

		$data['items'] = $this->categories_model->getCatItems($catID);

		//Check if category exists
		if ($data['category']==NULL)
		{
			$data['page'] = 'items/index';
			$data['title'] = 'Not Found';
			$data['returnMessage'] = 'That category cannot be found. The latest products are listed below.';
			$data['items'] = $this->items_model->getLatest();
			// Whoops, we don't have that category
		} elseif(is_array($data['items'])){
			$data['title'] = $data['category']['name'];
			$data['page'] = 'items/index';
		} else {
			$data['title'] = $data['category']['name'];
			$data['page'] = 'items/index';
			$data['returnMessage'] = 'That category is empty. The latest products are listed below.';
			$data['items'] = $this->items_model->getLatest();
		}
		$this->load->library('layout',$data);
	}

	// Callback functions, 

	// Check the category exists.
	public function check_category_exists($id){
		return  $this->categories_model->checkCategoryExists($id);
	}

}
