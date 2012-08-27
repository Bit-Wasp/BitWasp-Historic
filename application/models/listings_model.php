<?php
class Listings_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	// Remove the image from itemPhotos.
	public function removeImage($imageHash){
		// Select the image
		$this->db->where('imageHash',$imageHash);

		// Delete image from the table.
		$delete = $this->db->delete('itemPhotos');
		if($delete){
			// Image deleted.
			return TRUE;
		} else {
			// Unable to delete image from item.
			return FALSE;
		}
	}

	// Update information about the item.
	public function updateItem($itemHash,$array){
		// Select the item.
		$this->db->where('itemHash',$itemHash);

		// Update the item with the information in $array.
		$query = $this->db->update('items',$array);
		if($query){
			// Item has been updated.
			return TRUE;
		} else {
			// Unable to update the item.
			return FALSE;
		}
	}

	// Add item to the table.
	public function addItem($array){
		// Insert array into the items table.
		$query = $this->db->insert('items',$array);
		if($query){
			// Item has been inserted.
			return TRUE;
		} else {
			// Unable to add the item. 
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
				// Loop through images, and remove each from the item.
				$this->removeImage($row['imageHash']);
			}
		}

		// Remove the item from the table.
		$array = array( 'itemHash' => $itemHash,
				'sellerID' => $userHash);

		if($this->db->delete('items',$array)){
			// Item has been removed.
			return TRUE;
		} else {
			// Unable to remove the item.
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
				return TRUE;				// If the update is successful, return TRUE.
		} else {
			// Find another image for the product.
			$this->db->where('itemHash',$itemHash);
			$query = $this->db->get('itemPhotos');

			if($query->num_rows() > 0){
				// Update the item with the new image. 
				$row = $query->row_array();
				$this->db->where('itemHash',$itemHash);

				// Check the update is successful, and return TRUE. 
				if($this->db->update('items',array('mainPhotoHash' => $row['imageHash'])))
					return TRUE;
			} 
		}

		// Unable to update the main Image.
		return FALSE;
	}

	// Load an array of information about the image.
	public function getImageInfo($imageHash){
		// Specified by the image hash.
		$this->db->where('imageHash',$imageHash);
		$query = $this->db->get('itemPhotos');
		if($query->num_rows() > 0){
			// Return image info
			return $query->row_array();
		} else {
			// Otherwise it failed. 
			return NULL;
		}
	}

};

