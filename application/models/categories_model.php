<?php
class Categories_model extends CI_Model {

	public function __construct(){}

	//Load the requested user from the database by their userhash.
	public function get_list($catParent = FALSE)
	{
	
		//If no parent is specified, load all the categories.
		if ($catParent === FALSE)
		{
			$query = $this->db->get('categories');
			return $query->result_array();
		}
	
		//Otherwise, load the children of specified category.
		$query = $this->db->get_where('categories', array('parentID' => $catParent));
		return $query->result_array();
	}

	//Return information about a category
	public function get_cat($categorySlug = FALSE)
	{
	
		//If no category is specified, don't do anything.
		if ($categorySlug === FALSE)
		{
			return NULL;
		}
	
		//Otherwise, load the children of specified category.
		$query = $this->db->get_where('categories', array('slug' => $categorySlug));
		return $query->row_array();
	}
}
