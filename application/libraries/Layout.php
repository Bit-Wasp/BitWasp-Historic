<?php

class Layout  extends CI_Controller {

	public function __construct($params) {
		$data = $params;

		$CI = &get_instance();

//		print_r($CI->my_session->all_userdata());

		//register code to include header JS and meta.
		if(!isset($data['header_meta'])) {	
			$data['header_meta'] = ''; 
		}

		if($CI->session->userdata('logged_in') === TRUE){
			$headerFile = 'templates/'.strtolower($CI->my_session->userdata('userRole')).'Header';
			$CI->load->view($headerFile,$data);

			$CI->load->model('categories_model');
			$categories = $CI->categories_model->getCategories();

			//Check if there are categories to display
			if(!empty($categories))	{
				$category_data['cats'] = $this->createMenu($categories);
			} else {
				$category_data['cats'] = "No Categories";
			}
		} else {
			$CI->load->view('templates/loginHeader',$data);
			$category_data['cats'] = NULL;
		}

                $CI->load->view('templates/catSidebar', $category_data);

		$CI->load->view($data['page']);
		$CI->load->view('templates/footer.php');
	}
	
	public function createMenu($categories){
		$CI = &get_instance();
		$CI->load->model('categories_model');
		$content = '';
		$link = array();
		if( is_array($categories) ){
			foreach($categories as $key => $value){
				//echo $key.' - '.$value.'<br />';
				if( is_array($value) ){
					if($key == "name"){
						$content.= "$val<br />\n"; 
					}
					$content.= $this->createMenu($value);
				} else {
					$link[$key] = $value;
				} 

				if($key == 'children' && $value !== NULL && isset($link['name'])){
					$content.= "{$link['name']}<br />";
					unset($link);
				} else {				
					if( isset($link['id']) && isset($link['name']) ){
						$count = $CI->categories_model->countCategoryItems($link['id']);
						if($count > 0){
							$content.="<a href='".site_url()."/cat/{$link['id']}'>{$link['name']} ($count)</a><br />\n";
						} else {
							$content.="{$link['name']}<br />\n";
						}
						unset($link);	
					}
				}
				
			}
		}
		return $content;

	}



};



