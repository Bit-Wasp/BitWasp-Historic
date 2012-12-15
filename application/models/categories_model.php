<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->model('items_model');
	}

	public function moveCats($oldParent,$newParent){
		$this->db->where('parentID',$oldParent);
		$array = array('parentID' => $newParent);
		if($this->db->update('categories',$array)){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	// Move items from one category to another.
	public function moveCatItems($source,$destination){
		// Select the items by the source category.
		$this->db->where('category',$source);

		// Update the items with the new category.
		$array = array('category' => $destination);
		if($this->db->update('items',$array)){
			// Successful; items updated; return TRUE;
			return TRUE;
		} else {
			// Failure; Unable to update items.
			return FALSE;
		}
	}

	// Check category exists before trying to delete.
	public function checkCategoryExists($id){
		// See if the category exists.
		$query = $this->db->get_where('categories', array('id' => $id));
		if($query->num_rows() > 0){
			// Success; category exists. return TRUE;
			return TRUE;
		} else {
			// Failure; can't find category. return FALSE;
			return FALSE;
		}
	}

	// Category Information
	public function countCategoryItems($catID){
		$this->db->where('category', $catID);
		$this->db->from('items');
		// Return the number of items in the response.
		return $this->db->count_all_results();
	}

	public function countSubCategories($catID){
		$this->db->where('parentID',$catID);
		$this->db->from('categories');
		// Return the number of sub categories.
		return $this->db->count_all_results();
	}

	// Gather information about the category.
	public function catInfo($catID){
		// Select the category by the ID.
		$query = $this->db->get_where('categories',array('id' => $catID));
		if($query->num_rows() > 0){
			// Success; return category information.
			return $query->row_array();
		} else {
			// Failure; return NULL.
			return NULL;
		}
	}

	// Create a new Category
	public function addCategory($array){
		// Insert array of info into the table.
		$query = $this->db->insert('categories',$array);
		if($query){
			// Success; category added. 
			return TRUE;
		} else {
			// Failure; unable to add category; return FALSE;
			return FALSE;
		}
	}

	// Remove Category from the listings
	// Need to look at bumping all items into parent category, or require it be empty..
	public function removeCategory($categoryID){
		$query = $this->db->delete('categories', array('id' => $categoryID));
		if($query){ 
			// Success; category removed.
			return TRUE;
		} else {
			// Failure; unable to remove category. Return FALSE;
			return FALSE;
		} 
	}

	// List Items by Category
	public function getCatItems($limit, $start, $catID = NULL){
		// Check the category exists.
		if($catID === NULL){
			// No category selected for some reason. Show latest items as normal.
			return $this->products_model->getLatest();
		}

		// Get items in the chosen category.
		$this->db->limit($limit,$start);
		$this->db->where('hidden !=','1');
		$this->db->where('category',$catID);
		$query = $this->db->get('items');

		// If the category has items.
		if($query->num_rows() > 0){
			$result = $query->result_array();

			//Get more information for each item
			$this->load->model('images_model');
			$this->load->model('currency_model');
			// Loop through result as a pointer, add more info to $result.
			foreach($result AS &$item)
			{
				//Load the main image, and information about the vendor and currency.
				$item['itemImgs'] = $this->items_model->get_item_images($item['itemHash'],1);
				$item['vendor'] = $this->users_model->get_user(array('userHash' => $item['sellerID']));
				$item['symbol'] = $this->currency_model->get_symbol($item['currency']);
			}
			// Success; loaded category items.
			return $result;
		} else {
			// Failure; No items in this category. return FALSE.
			return FALSE;
		}
	}


	// Produce an unordered list of categories
	public function getList(){
		$array = array();

		// Select ID and Name for output on the form/
		$this->db->select('id, name');
		$query = $this->db->order_by("parentID asc, name asc");
		$query = $this->db->get('categories');

		// Check there are categories in the table. 
		if($query->num_rows() > 0){
			// Once there are categories, build the array from the returned object.
			foreach($query->result() as $result){
				array_push($array,array(
              				'id' => $result->id,
					'name' => $result->name
					)
				);
			}
			// Success; return array of categories.
			return $array;
		} else {
			// Failure; return FALSE;			
			return FALSE;
		}
	}

	// Load the number of items in a category.
	public function get_catItems_count($catID){
		$this->db->order_by('id DESC');
		$this->db->where('hidden !=', '1');
		$this->db->where('category', $catID);
		$query = $this->db->get('items');
		return $query->num_rows();
	}

	// Produce categories in a dynamic multi-dimensional array
	public function getCategories(){

		//Load all categories and sort by parent category
		$query = $this->db->order_by("parentID asc, name asc");
		$query = $this->db->get('categories');
		$menu = array();

		// Add all categories to $menu[] array.
		foreach($query->result() as $result){
      			$this->db->where('category',"{$result->id}");
      			$this->db->where('hidden !=', '1');
			$getProducts = $this->db->get('items');
			$menu[$result->id] = array('id' => $result->id,
						'name' => $result->name,
						'description' => $result->description,
						'countProducts' => $getProducts->num_rows(),
						'parentID' => $result->parentID
					);
		}
		
		// Store all child categories as an array $menu[parentID]['children']
		foreach($menu as $ID => &$menuItem){
			if($menuItem['parentID'] != '0')
				$menu[$menuItem['parentID']]['children'][$ID] = &$menuItem;
		}

		// Remove child categories from the first level of the $menu[] array.
		foreach(array_keys($menu) as $ID){
			if($menu[$ID]['parentID'] != "0")
				unset($menu[$ID]);
		}
		//print_r($menu);
		// Return constructed menu.
		return $menu;
	}

	
	// For callback functions
	// Check that selected parentID exists, before adding a sub-category.
	public function validParentID($parentID){
		$query = $this->db->get_where('categories', array('parentID' => $parentID));
		
		if($query->num_rows() > 0){
			return TRUE;
		} else {
			return TRUE;
		}
	}

}
