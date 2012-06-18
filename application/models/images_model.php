<?php
class Images_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function base64image($filename){
		$query = $this->db->select('encoded')
				->where('filename',$filename)
				->get('images');
		if($query->num_rows() !== 0){
			$result = $query->row_array();
			return $result['encoded'];
		} else {
			return FALSE;
		}
	}

	//Load the requested product's images from the database
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

                        return $this->base64image($array['imageName']);
		} 
		else { //Load an array of all images for current product
			$query = $this->db->get_where('productPhotos', array('productID' => $productID));
			$array = $query->result_array();
			$i = 0;
			foreach($array as $entry){
				$result[$i++] = $this->base64image($entry['imageName']);
			}
			return $result;
		}
	}
}
