<?php

class My_image {

	// want to create an uploader script
	public function loadImage($filename){
		$CI = &get_instance();
		$CI->load->model('images_model');
        
		$image = $CI->images_model->base64image($filename);
        if(empty($image)) {
			return FALSE;
		} else {
			return $image;
		}
    }

};


