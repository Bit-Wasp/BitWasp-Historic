<?php
class Pages_model extends CI_Model {

	public function __construct(){}

	public function getAuthLevel($URI){
		$this->db->select('authLevel')
			 ->where(array('URI' => $URI));
		$query = $this->db->get('pageAuthorization');
		if($query->num_rows() > 0){
			$row = $query->row_array();
			return $row['authLevel'];
		} else {
			// default be logged in!
			return false;
		}
	}

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
			return $query->row_array();
		} else {
			return FALSE;
		}
	}

}


