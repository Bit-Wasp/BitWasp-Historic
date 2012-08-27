<?php
class Pages_model extends CI_Model {

	public function __construct(){}

	//Load the requested user from the database by their userhash.
	public function get_page($slug = FALSE)
	{
	
		//If no user is specified, return nothing.
		if ($slug === FALSE)
		{
			return;
		}
	
		//Otherwise, load the user which corresponds to this page name.
		$query = $this->db->get_where('pages', array('slug' => $slug));

		if($query->num_rows() > 0){
			// The page exists, return the response.
			return $query->row_array();
		} else {
			// Otherwise return FALSE;
			return FALSE;
		}
	}

}


