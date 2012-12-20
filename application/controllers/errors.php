<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Errors extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public $error = array(	'forbidden'	=> array(	'title'	=> 'Forbidden',
								'http'	=> 403,
								'msg' 	=> 'Your are not authorized to view this page.' ),
				'itemNotFound'	=> array(	'title' => 'Item Not Found',
								'http'  => 404,
								'msg'	=> 'The item you have requested does not exist.'),
				'userNotFound'	=> array(	'title' => 'User Not Found',
								'http'  => 404,
								'msg'	=> 'The user you have requested does not exist.'),

				'pageNotFound'	=> array(	'title' => 'Page Not Found',
								'http'  => 404,
								'msg'	=> 'The page you have requested does not exist.')
			);



	public function index($param) {
	
		if(isset($this->error[$param]) && is_array($this->error[$param])){
			$errorInfo = $this->error[$param];
			$this->output->set_status_header($errorInfo['http']);
		} else {
			$errorInfo = array(	'title'	=> 'Error',
						'msg' => 'There was an error processing your request',
						'http' => null);
		}



		$data['page'] = 'errors/index.php';
		$data['title'] = "Error {$errorInfo['http']}";

		// Set the default <div> container; for a logged out user.
		$data['div'] = "<div class=\"offset3 span6\">";

		if($this->session->userdata('logged_in') == TRUE){
			$data['div'] = "<div class=\"span9 mainContent\" id=\"error-".$errorInfo['msg']."\">";
		}

		$data['error'] = $errorInfo;
		$this->load->library('Layout',$data);

	}
};
