<?php

class Listings extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('listings_model');
		$this->load->model('currency_model');
		$this->load->model('items_model');
		$this->load->model('orders_model');
		$this->load->library('my_image');
	}		

	// Edit Item Information
	// URI: item/edit/
	// Auth: Vendor
	public function edit($itemHash){
		$this->load->model('categories_model');
                $this->load->library('form_validation');

		// Check the item exists.
		$query = $this->db->get_where('items',array('itemHash' => $itemHash));
		if($query->num_rows() > 0){

			$itemInfo = $query->row_array();

			// Check the user is the seller.
			if($itemInfo['sellerID'] == $this->my_session->userdata('userHash')){

				// Finally check that the form validates correctly.
		                if ($this->form_validation->run('editItem') == FALSE){			
					// Form not submitted, or unsuccessful
		                        $data['title'] = 'Edit Item';
					$data['page'] = 'items/editItem';
					$data['categories'] = $this->categories_model->getList();
					$data['currencies'] = $this->currency_model->getList();
					$data['item'] = $this->items_model->getInfo($itemHash);
				} else {
					// Submission successful, update the item.
					$itemInfo = array(	'name' 		=> $this->input->post('name'),
								'description' 	=> $this->input->post('description'),
								'category' 	=> $this->input->post('categoryID'),
								'price' 	=> $this->input->post('price'),
								'currency' 	=> $this->input->post('currency')
							);
					
					$updateProduct = $this->listings_model->updateItem($itemHash,$itemInfo);
					// Try to update the product with the new image
					if($updateProduct === TRUE){

						// Item has been updated
						$data['title'] = 'Item Updated';
						$data['returnMessage'] = "Your item has been updated. ";

						// Get userHash from the session.
						$hash = $this->my_session->userdata('userHash');
						// Load the current users items.
						$data['items'] = $this->items_model->userListings($hash);
						// Load unconfirmed orders for the current user.
						$data['newOrders'] = $this->orders_model->ordersByStep($hash,1);
						// Load orders for dispatch
						$data['dispatchOrders'] = $this->orders_model->ordersByStep($hash,2); 

						$data['page'] = 'listings/manage';
					} else {
						// Update has failed. 
						$data['title'] = 'Edit Item';
						$data['page'] = 'items/editItem';
						$data['currencies'] = $this->currency_model->getList();
						$data['categories'] = $this->categories_model->getList();
						$data['returnMessage'] = "Unable to update your listing.";
						$data['item'] = $this->items_model->getInfo($itemHash);
					}
				}
			} else {
				// Not allowed edit this image.
				$data['title'] = 'Not Authorized';
				$data['returnMessage'] = "Unable to edit this item.";

				// Get userHash from the session.
				$hash = $this->my_session->userdata('userHash');
				// Load the current users items.
				$data['items'] = $this->items_model->userListings($hash);
				// Load unconfirmed orders for the current user.
				$data['newOrders'] = $this->orders_model->ordersByStep($hash,1);
				// Load orders for dispatch
				$data['dispatchOrders'] = $this->orders_model->ordersByStep($hash,2); 

				$data['page'] = 'listings/manage';
			}
		} else {
			// Item cannot be found.
			$data['title'] = 'Not Found';
			$data['returnMessage'] = "That item cannot be found.";

			// Get userHash from the session.
			$hash = $this->my_session->userdata('userHash');
			// Load the current users items.
			$data['items'] = $this->items_model->userListings($hash);
			// Load unconfirmed orders for the current user.
			$data['newOrders'] = $this->orders_model->ordersByStep($hash,1);
			// Load orders for dispatch
			$data['dispatchOrders'] = $this->orders_model->ordersByStep($hash,2); 

			$data['page'] = 'listings/manage';
		}	
                $this->load->library('Layout',$data);				
	}


	// Manage Vendor Listings
	// URI: listings/
	// Auth: Vendor
	public function manage(){

		$data['title'] = 'Manage Listings';
		$data['page'] = 'listings/manage';

		// Get userHash from the session.
		$hash = $this->my_session->userdata('userHash');
		// Load the current users items.
		$data['items'] = $this->items_model->userListings($hash);
		// Load unconfirmed orders for the current user.
		$data['newOrders'] = $this->orders_model->ordersByStep($hash,1);
		// Load orders for dispatch
		$data['dispatchOrders'] = $this->orders_model->ordersByStep($hash,2); 

		$this->load->library('layout',$data);
	}

	// Manage Item Images
	// URI: listings/images/
	// Auth: Vendor
	public function images($itemHash){
                $this->load->library('form_validation');

		// Load item information.
		$itemInfo = $this->items_model->getInfo($itemHash);

		// Check that the item exists.
		if($itemInfo === NULL){
			// Item does not exist.
			$data['title'] = 'Manage Listings';
			$data['page'] = 'listings/manage';
			$data['returnMessage'] = 'This item does not exist.';
			// Load unconfirmed orders for the current user.
			$data['newOrders'] = $this->orders_model->ordersByStep($sellerHash,1);
	
			// Load orders for dispatch
			$data['dispatchOrders'] = $this->orders_model->ordersByStep($sellerHash,2); 

			$hash = $this->my_session->userdata('userHash');
			$data['items'] = $this->items_model->userListings($hash);

		} else {
			// Check the seller's hash matches that stored in the table.
			if($itemInfo['sellerID'] == $this->my_session->userdata('userHash')){
				// User matches, show form and items for item.
		                $data['title'] = 'Item Images';
				$data['page'] = 'listings/images';
				$data['returnMessage'] = 'Select an image to upload.';
				$data['item'] = $this->items_model->getInfo($itemHash);
				$data['images'] = $this->items_model->get_item_images($itemHash);
			} else {
				// Seller hash does not match, display error.
				$data['title'] = 'Manage Listings';
				$data['page'] = 'listings/manage';
				$data['returnMessage'] = 'Unable to edit this item.';
				$hash = $this->my_session->userdata('userHash');
				$data['items'] = $this->items_model->userListings($hash);
			}

		}	

		$this->load->library('layout',$data);
	}

	// Function to change the main image for the item.
	// URI: listings/mainImage
	// Auth: Vendor
	public function mainImage($imageHash){
                $this->load->library('form_validation');
		$this->load->model('images_model');

		// Load information about the image.
		$imageInfo = $this->items_model->getImageInfo($imageHash);
		if($imageInfo === NULL){
			// Image does not exist. 
			$data['title'] = 'Item Images';
			$data['page'] = 'listings/images';

			// Load information about the item.
			$data['item'] = $this->items_model->getInfo($imageInfo['itemHash']);

			// Load the images for the item.
			$data['images'] = $this->items_model->get_item_images($imageInfo['itemHash']);
			$data['returnMessage'] = 'This image does not exist.';	
		} else {
			// Load information about the item.
			$itemInfo = $this->items_model->getInfo($imageInfo['itemHash']);

			// Check the item exists
			if($itemInfo === NULL){

				// Item does not exist
				$data['title'] = 'Item Images';
				$data['page'] = 'listings/images';
				$data['returnMessage'] = 'Item does not exist.';
				$data['item'] = $this->items_model->getInfo($imageInfo['itemHash']);
				$data['images'] = $this->items_model->get_item_images($imageInfo['itemHash']);

			} else {
				// Check the user can delete this image.
				if($itemInfo['sellerID'] == $this->my_session->userdata('userHash')){
					// Try update the main photo.
					if($this->items_model->fixMainPhoto($itemInfo['itemHash'],$imageInfo['imageHash'])){
						// Successful; item has been updated with new photo.
						$data['title'] = 'Item Images';
						$data['page'] = 'listings/images';
						$data['returnMessage'] = 'Main photo selected.';

						// Load information about the item.
						$data['item'] = $this->items_model->getInfo($imageInfo['itemHash']);

						// Load the images for the item.
						$data['images'] = $this->items_model->get_item_images($imageInfo['itemHash']);	
					} else {
						// Unsuccessful
						$data['title'] = 'Item Images';
						$data['page'] = 'listings/images';
						$data['returnMessage'] = 'Unable to update the main photo.';
						$data['item'] = $this->items_model->getInfo($imageInfo['itemHash']);
						$data['images'] = $this->items_model->get_item_images($imageInfo['itemHash']);	
					}	
				} else {
					// Seller hash does not match.
					$data['title'] = 'Item Images';
					$data['page'] = 'listings/images';
					$data['returnMessage'] = 'Not authorized to edit this image.';
					
					// Load info about the item.
					$data['item'] = $this->items_model->getInfo($imageInfo['itemHash']);

					// Load images for the item.
					$data['images'] = $this->items_model->get_item_images($imageInfo['itemHash']);
				}
			} 
		} 
		$this->load->library('layout',$data);
	}

	// Remove image from an item.
	// URI: listings/imageRemove/
	public function imageRemove($imageHash){
                $this->load->library('form_validation');
		$this->load->model('images_model');

		// Load information about the image.
		$imageInfo = $this->items_model->getImageInfo($imageHash);
		if($imageInfo === NULL){
			// Image cannot be found.
			$data['title'] = 'Item Images';
			$data['page'] = 'listings/images';
			$data['item'] = $this->items_model->getInfo($imageInfo['itemHash']);
			$data['images'] = $this->items_model->get_item_images($imageInfo['itemHash']);
			$data['returnMessage'] = 'This image does not exist.';		
		} else {
			// Load information about the item.
			$itemInfo = $this->items_model->getInfo($imageInfo['itemHash']);

			// Check the item exists
			if($itemInfo === NULL){
				// Item does not exist.
				$data['title'] = 'Item Images';
				$data['page'] = 'listings/images';
				$data['returnMessage'] = 'Item does not exist.';
				$data['item'] = $this->items_model->getInfo($imageInfo['itemHash']);
				$data['images'] = $this->items_model->get_item_images($imageInfo['itemHash']);
			} else {

				// Check the user can delete this image.
				if($itemInfo['sellerID'] == $this->my_session->userdata('userHash')){
					// Checks whether the image has been removed.
					$removeItemPhoto = FALSE;
					$removeImage = FALSE;

					// Remove the image from the item. 
					if($this->listings_model->removeImage($imageHash) === TRUE)
						$removeItemPhoto = TRUE;
						
					// Remove the image data from the table.
					if($this->images_model->removeImage($imageHash) === TRUE)
						$removeImage = TRUE;	

					// Check if this image is the main photo, and add a new one.
					if($itemInfo['mainPhotoHash'] == $imageHash)		
						$this->items_model->fixMainPhoto($itemInfo['itemHash']);

					$data['title'] = 'Item Images';
					$data['page'] = 'listings/images';
					// Work out the error message.
					if(($removeImage && $removeItemPhoto) || ($removeImage)){
						$data['returnMessage'] = 'Your image has been removed.';
					} else {
						$data['returnMessage'] = 'Unable to remove your image.';
					}
					$data['itemHash'] = $imageInfo['itemHash'];
					$data['item'] = $this->items_model->getInfo($imageInfo['itemHash']);
					$data['images'] = $this->items_model->get_item_images($imageInfo['itemHash']);
				} else {
					// Seller hash does not match.
					$data['title'] = 'Item Images';
					$data['page'] = 'listings/images';
					$data['returnMessage'] = 'Not authorized to edit this image.';
					
					// Load the item information
					$data['item'] = $this->items_model->getInfo($imageInfo['itemHash']);
					// Load the images for the item
					$data['images'] = $this->items_model->get_item_images($imageInfo['itemHash']);
				}
			} 
		} 
		$this->load->library('layout',$data);
	}

	// Process an image upload.
	// URI: listings/imageUpload
	// Auth: Vendor
	public function imageUpload($itemHash){
		$this->load->model('images_model');
                $this->load->library('form_validation');

		// Check that the specified product exists.
		$query = $this->db->get_where('items',array('itemHash' => $itemHash));
		if($query->num_rows() > 0){
			$itemInfo = $query->row_array();

			// Check the seller is the current user.
			if($itemInfo['sellerID'] == $this->my_session->userdata('userHash')){

				// Build the config file for the upload library.
				$config['upload_path'] = './assets/images/';    // Path to upload to. 
				$config['allowed_types'] = 'gif|jpg|jpeg|png';  // Allowed file types
				$config['max_size']	= '200';
				$config['max_width']  = '1024';
				$config['max_height']  = '768';
				$config['encrypt_name'] = true;			// Obfuscate filenames.
				$this->load->library('upload', $config);	// Build upload class.
		
				// Check if the upload is unsuccessful. 
				if(!$this->upload->do_upload()){
					// Image upload unsuccessful.
					$data['itemHash'] = $itemHash;
				        $data['title'] = 'Item Images';
					$data['page'] = 'listings/images';
					$data['returnMessage'] = 'Unable to upload your file.';
					$data['item'] = $this->items_model->getInfo($itemHash);
					$data['images'] = $this->items_model->get_item_images($itemHash);			
				} else {
					// Load the results of the upload into an array.
					$results = array('upload_data' => $this->upload->data());

		/*		
					// Print the EXIF data for the image.
					$exif = exif_read_data($results['upload_data']['full_path'], 0, true);
					echo "Removing EXIF data:<br />\n";
					foreach ($exif as $key => $section) {
		    				foreach ($section as $name => $val) {
						        echo "$key.$name: $val<br />\n";
						}
					}*/
					
					// Build the default file path to insert into the database.
					$source = $results['upload_data']['file_path'].$results['upload_data']['raw_name'].".png";

					// Strip the EXIF info from the image, and return the data for the cleaned image.
					$stripExif = array(	'full_path' => $results['upload_data']['full_path'],
								'raw_name' => $results['upload_data']['raw_name'],
								'file_ext' => $results['upload_data']['file_ext'] );
					// Returns the new file path info
					$cleanImage = $this->my_image->stripEXIF($stripExif,$source);

					// Get information about the item.
					$itemInfo = $this->items_model->getInfo($itemHash);

					// Build an array to add the image to the tables.
					$imgInfo = array('item' => $itemInfo,
							 'mainPhoto' => $this->input->post('mainPhoto'),
							 'encoded' => $this->my_image->simpleImageEncode($cleanImage['file_name']),
							 'imageHash' => $this->general->uniqueHash('images','imageHash')
							 );		
					// Associate image with item, and add to the image table.
					if($this->items_model->addProductImage($imgInfo) == TRUE){
						// Image added to the tables.
						$data['title'] = 'Image Created';
						$data['page'] = 'listings/images';	
						$data['returnMessage'] = 'Your image has been uploaded.';

						$data['item'] = $this->items_model->getInfo($itemHash);
						$data['images'] = $this->items_model->get_item_images($itemHash);

						// Remove any remaining image files.
						if(file_exists($cleanImage['destination']))
							unlink($cleanImage['destination']);
						if(file_exists($cleanImage['old_path']))
						 	unlink($cleanImage['old_path']);
					} else {
						// Unable to add image to the table.
		             			$this->load->library('form_validation');
						$data['title'] = 'Item Images';
						$data['page'] = 'listings/images';
						$data['returnMessage'] = 'Unable to add your image, please try again.';
						$data['item'] = $this->items_model->getInfo($itemHash);
						$data['images'] = $this->items_model->get_item_images($itemHash);
					}
				}
			} else {
				// Items seller does not match that of the user.
				$data['title'] = 'Not Authorized';
				$data['returnMessage'] = "Unable to edit this item. ";
				$hash = $this->my_session->userdata('userHash');
				$data['items'] = $this->items_model->userListings($hash);
				$data['page'] = 'listings/manage';
			}
		} else {
			// Item cannot be found.
			$data['title'] = 'Not Found';
			$data['returnMessage'] = "That item cannot be found.";
			$hash = $this->my_session->userdata('userHash');
			$data['items'] = $this->items_model->userListings($hash);
			$data['page'] = 'listings/manage';
		}
		$this->load->library('layout',$data);
	}

	// Remove Item from Vendor Listings
	// URI: listings/remove/
	// Auth: Vendor
	public function remove($itemHash){
		$itemInfo = $this->items_model->get_items($itemHash);
		$userHash = $this->my_session->userdata('userHash');
		//Check if the current user is allowed to remove this item
		if($this->my_session->userdata('userHash') == $itemInfo['sellerID']){
			$remove = $this->listings_model->remove($itemHash,$userHash);
			if($remove === TRUE){
				$data['returnMessage'] = 'Your item has been removed.';
			} else {
				$data['returnMessage'] = 'Unable to remove this product.';
			}

			//Item has been removed. Show the users other items
			$data['title'] = 'Item Removed';
			$data['page'] = 'listings/manage';
			$data['items'] = $this->items_model->userListings($userHash);
			$hash = $this->my_session->userdata('userHash');
		} else {
			// Current user is not the seller of this item. Give them an errror and display their items.
			$data['title'] = 'Remove Item';
			$data['page'] = 'listings/manage';
			$data['items'] = $this->items_model->userListings($userHash);
			$data['returnMessage'] = 'You are not authorized to delete this image.';
		}
		$this->load->library('layout',$data);
	}

// Create a new Item
	// URI: listings/create/
	// Auth: Vendor
	public function create(){
		$this->load->model('categories_model');
                $this->load->library('form_validation');

                if ($this->form_validation->run('addItem') == FALSE){			
			// form not submitted, or unsuccessful
                        $data['title'] = 'Add Item';
			$data['page'] = 'listings/addItem';
			$data['currencies'] = $this->currency_model->getList();
			$data['categories'] = $this->categories_model->getList();

		} else {
			// Form submission successful, add product to database.
			
			$hash = $this->general->uniqueHash('items','itemHash');
			$itemInfo = array(	'name' 		=> $this->input->post('name'),
						'description' 	=> $this->input->post('description'),
						'category'	=> $this->input->post('categoryID'),
						'itemHash'	=> $hash,
						'sellerID' 	=> $this->my_session->userdata('userHash'),
						'price'		=> $this->input->post('price'),
						'currency'	=> $this->input->post('currency') );
			$submitProduct = $this->listings_model->addItem($itemInfo);
			if($submitProduct === FALSE){
				// Some error with submission.
                       		$data['title'] = 'Add Item';
				$data['returnMessage'] = 'Unable to create your product, please try again.';
				$data['page'] = 'listings/addItem';
				$data['categories'] = $this->categories_model->getList();

			} else {
				// Product created
                       		$data['title'] = 'Item Created';
				$data['returnMessage'] = 'Your item has been created. You can now select an image to upload.';

				$data['item'] = $this->items_model->getInfo($hash);
				$data['images'] = $this->items_model->get_item_images($hash);

				$data['page'] = 'listings/images';		
			}
		}	
                $this->load->library('Layout',$data);				
	}
};

