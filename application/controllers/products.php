<?php

class Products extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('products_model');
		$this->load->model('users_model');
		$this->load->library('my_session');
		$this->load->library('my_image');
	}

	//View product listing
	public function index()	{
		// Check the user has logged in
		$this->my_session->checkAuth('login');

		//Load all the products
		$data['products'] = $this->products_model->get_products();
		$data['title'] = 'Products';
		$data['page'] = 'products/index';
		$this->load->library('layout',$data);
	}

	//View individual product
	public function view($productHash){
    	
		$this->my_session->checkAuth('login');

		$data['product'] = $this->products_model->get_products($productHash);
		//Check if product exists
		if ($data['product']==NULL)
		{
			$data['title'] = 'Not Found';
			$data['page'] = 'products/notFound';
			$this->load->library('layout',$data);
			// Whoops, we don't have a page for that!
		}

		$data['title'] = $data['product']['name'];
		$data['page'] = 'products/individual';
		$this->load->library('layout',$data);
	}

	//View category page and show sub products
	public function cat($categorySlug = FALSE){
                $this->my_session->checkAuth('login');

		//Load information about current category
		$this->load->model('categories_model');
		$data['category'] = $this->categories_model->get_cat($categorySlug);

		//Check if category exists
		if ($data['category']==NULL)
		{
			// Whoops, we don't have a page for that!
			show_error('The requested category could not be found. Please check your link.', '404');
		}

		//Load all the products
		$data['products'] = $this->products_model->get_products();
		$data['title'] = $data['category']['name'];
		$data['page'] = 'products/index';
		$this->load->library('layout',$data);
	}
}
