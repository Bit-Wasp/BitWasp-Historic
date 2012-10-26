<?php

class Layout  extends CI_Controller {

	public function __construct($params) {
		$data = $params;

		$CI = &get_instance();

	  	$CI->load->library('my_config');
		$data['site_name'] = $CI->my_config->site_title();

		//register code to include header JS and meta.
		if(!isset($data['header_meta'])) {	
			$data['header_meta'] = ''; 
		}

		if($CI->session->userdata('logged_in') === TRUE){

      //Load data needed for header menu.
			$CI->load->model('messages_model');
			$data['unreadMessages'] = $CI->messages_model->getUnread($CI->session->userdata('id'));
			$headerFile = 'templates/'.strtolower($CI->my_session->userdata('userRole')).'Header';
			$CI->load->view($headerFile,$data);

      //Begin loading category data
			$CI->load->model('categories_model');
			$categories = $CI->categories_model->getCategories();

			//Check if there are categories to display
			if(!isset($data['currentCat'])){ $data['currentCat'] = array(); } //Set to avoid notice errors if unset

			if(!empty($categories))	{
				$category_data['cats'] = $this->createMenu($categories , 0, $data['currentCat']); //Pass params so we can show active class on current cat.
			} else {
				$category_data['cats'] = "No Categories";
			}
      $CI->load->view('templates/catSidebar', $category_data);
		} else if($CI->session->userdata('twoStep') === TRUE){
			$CI->load->view('templates/twoStepHeader',$data);
			$category_data['cats'] = "";
		} else if($CI->session->userdata('forcePGP') === TRUE){
			$CI->load->view('templates/registerPGPHeader',$data);
			$category_data['cats'] = "";
		} else {
			$data['allow_reg'] = true;
			if($CI->my_config->registration_allowed() == 'Disabled')
				$data['allow_reg'] = false;
			$CI->load->view('templates/loginHeader',$data);
			$category_data['cats'] = NULL;
		}

		$CI->load->view($data['page']);
		$CI->load->view('templates/footer.php');
	}

  //Output the categories as an unordered list.
	public function createMenu($categories, $level, $params){
		if(!isset($content)) { $content = ''; } $level++; //Create $content variable, if its not set
		if($level!=1) { $content .= "<ul>\n"; }

		// Loop through each parent category
		foreach($categories as $category) {
			//Check if were are currently viewing this category, if so, set it as active
			$content .= "<li "; if(isset($params['id'])) { if($params['id']==$category['id']){ $content .= "class='active'"; }} $content .= ">\n";

			if($category['countProducts']==0){ //Check if category has products and should be linked too
				$content .= '<span>'.$category['name'].'</span>';
			} else {
				$content .= '<a href="'.site_url().'cat/'.$category['id'].'">'.$category['name'].' ('. $category['countProducts'] .")</a>\n";
			}

			if(isset($category['children'])) { //Check if we need to recurse into children.
				$content .= $this->createMenu($category['children'], $level, $params); //Begin creating sub menu
			}
			$content .= "</li>\n";
		}

		if($level!=1) { $content .= "</ul>\n"; }

		return $content;
	}

};



