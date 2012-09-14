<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('categories_model');
	}

	public function index(){
		$data['title'] = 'Dashboard';
		$data['page'] = 'admin/index';
		$this->load->library('layout',$data);
	}

	public function siteInfo(){
		$data['page'] = 'admin/siteInfo';
		$data['title'] = 'Site Info';
		$data['config'] = $this->my_config->loadAll();

		$t = array(	'site_title' => 'Bitwasp :: Anonymous Online Marketplace',
				'login_timeout' => '30',
				'base_url' => 'http://178.238.140.54/bitwasp/' );
		echo json_encode($t);
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

