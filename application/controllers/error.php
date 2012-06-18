<?php

class Error extends CI_Controller {

	public function __construct() {}

	public function forbidden() {
		show_error('Not authorized to view this page','403');
	}

};
