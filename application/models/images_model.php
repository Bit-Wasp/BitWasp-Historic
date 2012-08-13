<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Images_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function imageFromDB($imageHash){
		$query = $this->db->select('encoded, height, width')
				->where('imageHash',$imageHash)
				->get('images');
	
		$result = array();

		if($query->num_rows() !== 0){
			// Image exists, return encoded base64. 
			$result = $query->row_array(); 
		} else {
			$result = NULL;
		}

		return $result;
	}

	public function removeImage($imageHash){
		$query = $this->db->get_where('images',array('imageHash' => $imageHash));
		if($query->num_rows() > 0){
			$this->db->where('imageHash',$imageHash);
			$delete = $this->db->delete('images');
			if(!$delete){
				return FALSE;
			} else {
				return TRUE;
			}
		} else {
			return NULL;
		}
	}

	public function addBase64Image($imageHash){
		$query = $this->db->select('encoded')
				  ->where('imageHash',$imageHash)
				  ->get('images');
		if($query->num_rows() !== 0){
			return FALSE;
		} else {
			$insertArray = array(	'encoded' => $this->my_image->simpleImageEncode($identifier),
						'imageHash' => $imageHash  );
			if($this->db->insert('images',$insertArray)){
				return TRUE;				
			} else {
				return FALSE;
			}			
		}
	}


}
