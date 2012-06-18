<?php

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('my_image');
	}

	public function index($img){
		echo "<img alt=\"\" src=\"data:image/jpeg;base64,".$this->my_image->loadImage($img)."\">";

	}

};

