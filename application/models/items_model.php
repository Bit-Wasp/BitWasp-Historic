<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Items_model extends CI_Model {
	public function __construct(){	
		parent::__construct();
		$this->load->model('images_model');
	}

	// Get information about an item.
	public function getInfo($itemHash){
		// Load information by the itemHash
		$query = $this->db->get_where('items',array('itemHash' => $itemHash));
		if($query->num_rows() > 0){
			// Success; Return the information
			return $query->row_array();
		} else {
			// Failure; return NULL.
			return NULL;
		}
	}

	// Load an array of information about the image.
	public function getImageInfo($imageHash){
		// Load info specified by the image hash.
		$this->db->where('imageHash',$imageHash);
		$query = $this->db->get('itemPhotos');
		if($query->num_rows() > 0){
			// Success; return image information.
			return $query->row_array();
		} else {
			// Failure; return NULL.
			return NULL;
		}
	}

	// Add the product to itemPhotos and images.
	public function addProductImage($array){
		// Get the number of photos for that item.
		$query = $this->db->get_where('itemPhotos',array('itemHash' => $array['item']['itemHash']));
		$count = $query->num_rows();

		// Add image to itemPhotos
		$imagePhoto = array(	'itemHash' => $array['item']['itemHash'],
					'imageHash' => $array['imageHash']);
	
		// If unable to insert update the item with the image, return FALSE
		if(!$this->db->insert('itemPhotos',$imagePhoto)){
			return FALSE;
		}

		// Check if this image is the new main image, or if there are no other images.
		if($array['mainPhoto'] == '1' || $count == 0){
			// Update the items table to store the mainPhoto
			$this->db->where('itemHash', $array['item']['itemHash']);
			$this->db->update('items',array('mainPhotoHash' => $array['imageHash']));		
		}

		// Encode the image and store it in the DB.
		$image = array( 'encoded' => $array['encoded'],
				'imageHash' => $array['imageHash'],
				'height' => '120',
				'width' => '160' );

		// Insert the image content into the table.
		if($this->db->insert('images',$image)){
			// Success; image has been added.
			return TRUE;
		} else {		
			// Failure; return FALSE.
			return FALSE;
		}
	}

	// Load  items for the specified user.
	public function userListings($userHash){
		$query = $this->db->get_where('items',array('sellerID' => $userHash));
		
		//Get more information for each item
		$this->load->model('images_model');
		$this->load->model('currency_model');

		// If the user has listings
		if($query->num_rows() > 0){
			$result = $query->result_array();

			// Loop each result as a pointer, and add more information to $result.
			foreach($result AS &$item){
				//Load the main image for this item
				$item['itemImgs'] = $this->get_item_images($item['itemHash'],1);
	
				//Load the vendors information
				$item['vendor'] = $this->users_model->get_user(array('userHash' => $item['sellerID']));
			
				// Load the symbol for the currency.
				$item['symbol'] = $this->currency_model->get_symbol($item['currency']);
			}
			// Success; return the array.
			return $result;
		} else {
			// No listings; return NULL;
			return NULL;
		}
	}

	// Load the latest products, can specify the number to return.
	public function getLatest($count = 20){

		// Display most recent items.
		$this->db->order_by('id DESC');
		$this->db->where('hidden !=', '1');
		$query = $this->db->get('items');
	

		if($query->num_rows() > 0){
			$result = $query->result_array();
	
			//Get more information for each item
			$this->load->model('images_model');
			$this->load->model('currency_model');
			foreach($result AS &$item){
				//Load the main image for this item
				$item['itemImgs'] = $this->get_item_images($item['itemHash'],1);
				//Load the vendors information
				$item['vendor'] = $this->users_model->get_user(array('userHash' => $item['sellerID']));
				$item['symbol'] = $this->currency_model->get_symbol($item['currency']);
			}
			return $result;
		} else {
			// Failure; no listings. Return NULL.
			return NULL;
		}
	}


	//Load the requested items from the database
	public function get_items($itemHash = FALSE){
	
		//If no item is specified, load all the items
		if ($itemHash === FALSE){
			return $this->getLatest();
		}

		//Otherwise, load the data for the specified item
		$query = $this->db->get_where('items', array('itemHash' => $itemHash));
		$result = $query->row_array();

		//Check that this item was found
		if ($query->num_rows() > 0){

			//Load all the images for this item
			$this->load->model('images_model');
			$this->load->model('currency_model');
			$result['itemImgs'] = $this->get_item_images($itemHash);

			// Load the symbol for the currency.
			$result['symbol'] = $this->currency_model->get_symbol($result['currency']);

			//Load the vendors information
			$this->load->model('users_model');
			$result['vendor'] = $this->users_model->get_user(array('userHash' => $result['sellerID']));
			
			// Success; return the result.
			return $result;
		} else { 
			// Failure; no items. Return NULL.
			return NULL;
		}
	}



	//Get the images for a particular item
	public function get_item_images($itemHash = FALSE, $mainPhoto = FALSE){
		$this->load->library('my_image');
	        //If no item ID is given or no images are found for that item. Show the default image.
	        if ($itemHash === FALSE) {
	                $query = $this->db->get_where('images', array('imageHash' => 'default'));
                	$result = $query->row_array();
			// Display the base64 image
                	$data = $this->my_image->displayImage($result);

                	return $data;
	        }

		// Load the item from the model.
               	$query = $this->db->get_where('items', array('itemHash' => $itemHash));
       		$result = $query->row_array();

	        //Check if only the main image is requested
	        if($mainPhoto == 1){
			// Check the product exists
			if($query->num_rows() > 0){
				// Load the main image or show the default one.
	      $itemPhotos = $this->db->get_where('itemPhotos', array('imageHash' => $result['mainPhotoHash']));
				if($itemPhotos->num_rows() > 0){
					// Load image information.
		                	$array = $itemPhotos->row_array();

					// Extract the base64 image.
		                	$variable = $this->my_image->displayImage($array['imageHash']);
				} else {
					// Load the default image.
					$defaultImage = $this->db->get_where('images', array('imageHash' => 'default'));
					$array = $defaultImage->row_array();

					// Load the base64 image
					$variable = $this->my_image->displayImage($array['imageHash']);
				}
				// Return image info.
				return $variable;
			}
            	}  else { 
			//Load an array of all images for current item
		    	$variable = array();
                	$getPhotos = $this->db->get_where('itemPhotos', array('itemHash' => $itemHash));
                	$i = 0;
			// Loop through results
                	foreach($getPhotos->result_array() as $entry){
				// Load the base64 image
				$tmp = $this->my_image->displayImage($entry['imageHash']);
				$variable[$i++] = $tmp;
				// Add the image to the results
                	}
			// Return results with image info.
                	return $variable;
            	}
	}

}
