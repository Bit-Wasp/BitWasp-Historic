<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Images_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}


	// Load an array of information about the image.
	public function getImageInfo($imageHash){
		// Load by the image hash.
		$this->db->where('imageHash',$imageHash);
		$query = $this->db->get('itemPhotos');

		// Check the image exists. 
		if($query->num_rows() > 0){
			// Success; Return image info.
			return $query->row_array();
		} else {
			// Failure; image not there. Return NULL.
			return NULL;
		}
	}

	// Load the image from the DB.
	public function imageFromDB($imageHash){
		// Load image from the DB.
		$query = $this->db->select('encoded, height, width')
				->where('imageHash',$imageHash)
				->get('images');
	
		$result = array();

		// Check the image exists.
		if($query->num_rows() !== 0){
			// Success, return encoded base64. 
			return $query->row_array(); 
		} else {
			// Failure, return NULL.
			return NULL;
		}
	}

	// Remove the image from the DB.
	public function removeImage($imageHash){
		// Load the image by imageHash
		$query = $this->db->get_where('images',array('imageHash' => $imageHash));

		// Check the image exists.
		if($query->num_rows() > 0){
			// Delete from the table.
			$this->db->where('imageHash',$imageHash);
			$delete = $this->db->delete('images');
			if(!$delete){
				// Failure; return FALSE;
				return FALSE;
			} else {
				// Success; image removed. Return TRUE;
				return TRUE;
			}
		} else {
			// Failure; image does not exist.
			return NULL;
		}
	}

	// Add the base64 image to the database.
	public function addBase64Image($imageHash){
		// Check if the imageHash exists.
		$query = $this->db->select('encoded')
				  ->where('imageHash',$imageHash)
				  ->get('images');
		if($query->num_rows() !== 0){
			// Failure; Image already exists. Return FALSE;
			return FALSE;
		} else {
			// Insert the image to the table.
			$insertArray = array(	'encoded' => $this->my_image->simpleImageEncode($identifier),
						'imageHash' => $imageHash  );
			if($this->db->insert('images',$insertArray)){
				// Success; Image added. Return FALSE;
				return TRUE;				
			} else {
				// Failure; Unable to add the image. Return FALSE;
				return FALSE;
			}			
		}
	}
}
