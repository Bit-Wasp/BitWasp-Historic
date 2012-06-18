<?php

class User_Model extends CI_Model {

	public function __construct() {}

        //Load the requested user from the database by their userhash.
        public function get_user($userHash = FALSE)
        {

                //If no user is specified, return nothing.
                if ($userHash === FALSE)
                {
                        return NULL;
                }

                //Otherwise, load the user which corresponds to this hash.
                $this->db->select('id, userName, userRole, userHash, rating, timeRegistered');
                $query = $this->db->get_where('users', array('userHash' => $userHash));
		if($query->num_rows() > 0){
	                return $query->row_array();
		} else {
			return false;
		}
        }

        public function get_user_by_id($id = FALSE)
        {

                //If no user is specified, return nothing.
                if ($id === FALSE)
                {
                        return NULL;
                }

                //Otherwise, load the user which corresponds to this ID.
                $this->db->select('id, userName, userRole, userHash, rating');
                $query = $this->db->get_where('users', array('id' => $id));
                return $query->row_array(); //Return 1 result
        }

};
