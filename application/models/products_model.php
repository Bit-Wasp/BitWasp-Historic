<?php
class Products_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->model('images_model');
	}


	//Load the requested products from the database
	public function get_products($productHash = FALSE)
	{
	
		//If no product is specified, load all the products
		if ($productHash === FALSE)
		{
			$query = $this->db->get('products');
			$result = $query->result_array();

			//Get more information for each product
			$this->load->model('images_model');
			$this->load->model('user_model');
			$this->load->model('currency_model');
			foreach($result AS &$product)
			{
				//Load the main image for this product
				$product['productImgs'] = $this->get_product_images($product['id'],1);
				//Load the vendors information
				$product['vendor'] = $this->user_model->get_user($product['sellerID']);
				$product['symbol'] = $this->currency_model->get_symbol($product['currency']);
			}

			return $result;
		}

		//Otherwise, load the data for the specified product
		$query = $this->db->get_where('products', array('productHash' => $productHash));
		$result = $query->row_array();

		//Check that this product was found
		if ($query->num_rows() > 0){

			//Load all the images for this product
			$this->load->model('images_model');
			$this->load->model('currency_model');
			$result['productImgs'] = $this->get_product_images($result['id']);
			$result['symbol'] = $this->currency_model->get_symbol($result['currency']);

			//Load the vendors information
			$this->load->model('user_model');
			$result['vendor'] = $this->user_model->get_user($result['sellerID']);
			
			return $result;
		} else { //No matching products found
			return NULL;
		}
	}

	//Get the images for a particular product
    public function get_product_images($productID = FALSE, $mainPhoto = FALSE)
    {

            //If no product ID is given or no images are found for that product. Show the default image.
            if ($productID === FALSE)
            {
                    $query = $this->db->get_where('productPhotos', array('id' => 1));
                    $result = $query->row_array();
                    $data = $this->base64image($result);
                    return $data;
            }

            //Check if only the main image is requested
            if($mainPhoto == 1)
            {
                    $this->db->select('mainPhotoID');
                    $query = $this->db->get_where('products', array('id' => $productID));
                    $result = $query->row_array();

                    $query = $this->db->get_where('productPhotos', array('id' => $result['mainPhotoID']));
                    $array = $query->row_array();

                    return $this->images_model->base64image($array['imageName']);
            } 
            else { //Load an array of all images for current product
                    $query = $this->db->get_where('productPhotos', array('productID' => $productID));
                    $array = $query->result_array();
                    $i = 0;
                    foreach($array as $entry){
                            $result[$i++] = $this->images_model->base64image($entry['imageName']);
                    }
                    return $result;
            }
    }
}
