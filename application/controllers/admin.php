<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('categories_model');
	}

	public function index(){
		$data['title'] = 'Admin Panel';
		$data['page'] = 'admin/siteConfig';
	
		// Load the site configuration
		$data['config'] = $this->my_config->loadAll();
		
		$this->load->library('layout',$data);
	}

	public function editConfig(){
		$this->load->library('form_validation');
		$data['page'] = 'admin/editConfig';
		$data['title'] = 'Edit Configuration';

		// Load the site configuration
		$data['config'] = $this->my_config->loadAll();

		$this->load->library('layout',$data);
	}

	public function updateConfig(){
		$this->load->model('general_model');

		// Load the site configuration
		$data['config'] = $this->my_config->loadAll();

		// Check which fields are being updated
		if($this->input->post('site_title') !== $data['config']['site_title']){
			$newConfig['site_title'] = $this->input->post('site_title');
		} else {
			$newConfig['site_title'] = $data['config']['site_title'];
		}

		if($this->input->post('login_timeout') !== $data['config']['login_timeout']){
			$newConfig['login_timeout'] = $this->input->post('login_timeout');
		} else {
			$newConfig['login_timeout'] = $data['config']['login_timeout'];
		}

		if($this->input->post('base_url') !== $data['config']['base_url']){
			$newConfig['base_url'] = $this->input->post('base_url');
		} else {
			$newConfig['base_url'] = $data['config']['base_url'];
		}

		if($this->input->post('registration_allowed') !== $data['config']['registration_allowed']){
			$newConfig['registration_allowed'] = $this->input->post('registration_allowed');
		} else {
			$newConfig['registration_allowed'] = $data['config']['registration_allowed'];
		}

		if($this->input->post('force_vendor_PGP') !== $data['config']['force_vendor_PGP']){
			$newConfig['force_vendor_PGP'] = $this->input->post('force_vendor_PGP');
		} else { 
			$newConfig['force_vendor_PGP'] = $data['config']['force_vendor_PGP'];
		}

		if($this->input->post('index_page') !== $data['config']['index_page']){
			$newConfig['index_page'] = $this->input->post('index_page');
		} else {
			$newConfig['index_page'] = $data['config']['index_page'];
		}

		if($this->input->post('captcha_length') !== $data['config']['captcha_length']){
			$newConfig['captcha_length'] = $this->input->post('captcha_length');
		} else {
			$newConfig['captcha_length'] = $data['config']['index_page'];
		}

		// Build the json string
		$jsonConfig = json_encode($newConfig);

		// Update the site configuration
		if($this->general_model->updateConfig($jsonConfig)){
			$data['title'] = 'Site Configuration';
			$data['page'] = 'admin/siteConfig';
			$data['returnMessage'] = 'Your settings have been updated.';
		} else {
			$data['title'] = 'Update Configuration';
			$data['page'] = 'admin/edit';
			$data['returnMessage'] = 'There was a problem with your submission.';
		}
		
		$this->load->library('layout',$data);
	}

	public function fixOrphans(){
		$this->load->library('form_validation');
			
		if($this->form_validation->run('fixOrphanCategories') == FALSE){
			// Not completed properly, refer back to Category Removed page with the form.
			$data['title'] = 'Category Removed';
			$data['returnMessage'] = 'Your category has been removed.';
			$data['page'] = 'admin/removeCategorySuccess';

			// Need to see how many orphaned products there are.
			$categoryID = $this->input->post('oldCat');
			$data['oldCat'] = $categoryID;
			$data['currentCats'] = $this->categories_model->getList();
			$data['countSpare'] = $this->categories_model->countCategoryItems($categoryID);

		} else {
			// Form submission successful
			$destination = $this->input->post('categoryID');
			$oldCat = $this->input->post('oldCat');
			if($this->categories_model->moveCatItems($oldCat,$destination) === TRUE){
				$data['title'] = "Fixed Orphan Items";
				$data['returnMessage'] = 'The orphaned items have now been reassigned.';
				$data['page'] = 'admin/index';
			} else {
				// Not completed properly, refer back to Category Removed page with the form.
				$data['title'] = 'Category Removed';
				$data['page'] = 'admin/removeCategorySuccess';
	
				// Need to see how many orphaned products there are.
				$categoryID = $this->input->post('oldCat');	
				$data['oldCat'] = $categoryID;
				$data['currentCats'] = $this->categories_model->getList();
				$data['countSpare'] = $this->categories_model->countCategoryItems($categoryID);
			}
		}
		$this->load->library('layout',$data);

	}

	public function removeCategory(){
                $this->load->library('form_validation');

                if ($this->form_validation->run('removeCategory') == FALSE){
			$data['title'] = 'Remove Category';
			$data['page'] = 'admin/removeCategory';
			$data['subCats'] = $this->categories_model->getList();

		} else {
			$categoryID = $this->input->post('categoryID');
			if($this->categories_model->removeCategory($categoryID) === TRUE){
				// Success!
				$data['title'] = 'Category Removed';
				$data['page'] = 'admin/removeCategorySuccess';

				// Need to see how many orphaned products there are.
				$data['oldCat'] = $categoryID;
				$data['currentCats'] = $this->categories_model->getList();
				$data['countSpare'] = $this->categories_model->countCategoryItems($categoryID);
			} else {
				// Problem removing category.
				$data['title'] = 'Remove Category';
				$data['returnMessage'] = "Unable to remove this category, please try again.";
				$data['page'] = 'admin/removeCategory';
			}
		}
		$this->load->library('layout',$data);
	}


	public function addCategory(){
                $this->load->library('form_validation');

                if ($this->form_validation->run('addCategory') == FALSE){
			$data['title'] = 'Add Category';
			$data['page'] = 'admin/addCategory';
			$data['subCats'] = $this->categories_model->getList();
		} else {
			$categoryArray = array( 'name'		=> $this->input->post('name'),
						'description'	=> $this->input->post('description'),
						'parentID'	=> $this->input->post('parentID')
					);
			if($this->categories_model->addCategory($categoryArray) === TRUE){
				$data['title'] = 'Category Added';
				$data['returnMessage'] = 'Your category has been created!';
				$data['page'] = 'admin/index';
				// success!
			} else {
				$data['title'] = 'Add Category';
				$data['returnMessage'] = 'Unable to add your category, please try again.';
				$data['page'] = 'admin/addCategory';
				$data['subCats'] = $this->categories_model->getList();
				// failure; unable to add the category.
			}

		}
		$this->load->library('layout',$data);
	}

	// Callback functions

	// Check the category's parent ID exists
	public function check_parentID_exists($parentID){
		return  $this->categories_model->validParentID($parentID);
	}

	// Check the category ID exists.
	public function check_category_exists($id){
		return  $this->categories_model->checkCategoryExists($id);
	}
	
	

	
};

