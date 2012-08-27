<?php
class Listings_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	// Remove the image from itemPhotos.
	public function removeImage($imageHash){
		$this->db->where('imageHash',$imageHash);
		$delete = $this->db->delete('itemPhotos');
		if($delete){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	// Update information about the item.
	public function updateItem($itemHash,$array){
		$this->db->where('itemHash',$itemHash);
		$query = $this->db->update('items',$array);
		if($query){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	// Add item to the table.
	public function addItem($array){
		$query = $this->db->insert('items',$array);
		if($query){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	// Delete the item from the items table.
	public function remove($itemHash, $userHash){
		// Get images for that item.
		$query = $this->db->get_where('itemPhotos', array('itemHash' => $itemHash));

		// Check if there are any images, and remove them.
		if($query->num_rows() > 0){
			foreach($query->result_array() as $row){
				$this->removeImage($row['imageHash']);
			}
		}

		// Remove the item from the table.
		$array = array( 'itemHash' => $itemHash,
				'sellerID' => $userHash);

		if($this->db->delete('items',$array)){
			return TRUE;
		} else {
			return FALSE;
		}
		
	}

	// Set mainphoto as imagehash, or pull another image for the item.
	public function fixMainPhoto($itemHash, $imageHash = null){
		// Check if we are updating it, or repairing a removed file.
		if($imageHash !== null){
			// Update the item with the specificied image hash.
			$this->db->where('itemHash',$itemHash);
			if($this->db->update('items',array('mainPhotoHash' => $imageHash)))
				return TRUE;
		} else { 
			// Find another image for the product.
			$this->db->where('itemHash',$itemHash);
			$query = $this->db->get('itemPhotos');
			if($query->num_rows() > 0){
				// Update the item with the newimage.
				$row = $query->row_array();
				$this->db->where('itemHash',$itemHash);
				if($this->db->update('items',array('mainPhotoHash' => $row['imageHash'])))
					return TRUE;
			} 
		}
		return FALSE;
	}

	// Load an array of information about the image.
	public function getImageInfo($imageHash){
		$this->db->where('imageHash',$imageHash);
		$query = $this->db->get('itemPhotos');
		if($query->num_rows() > 0){
			return $query->row_array();
		} else {
			return NULL;
		}
	}

};

