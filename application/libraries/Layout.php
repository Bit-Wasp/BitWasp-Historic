<?php

class Layout  extends CI_Controller {

	public function __construct($params) {
		$data = $params;

		$CI = &get_instance();
		$CI->load->library('my_session');

//		print_r($CI->my_session->all_userdata());

		if($CI->session->userdata('logged_in') === TRUE){
			$headerFile = 'templates/'.strtolower($CI->my_session->userdata('userRole')).'Header';
			$CI->load->view($headerFile,$data);
		} else {
			$CI->load->view('templates/loginHeader',$data);
		}


                //Load a list of categories
                $CI->load->model('categories_model');
                $category_data['cats'] = $CI->categories_model->get_list();
                $CI->load->view('templates/catSidebar', $category_data);


		$CI->load->view($data['page']);
		$CI->load->view('templates/footer.php');
	}

};



