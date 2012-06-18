<?php

class My_captcha {

	public function __construct(){
		// delete captcha info over two hours
		$CI = &get_instance();
		$CI->db->where('time <',time()-7200);
		$CI->db->delete('captchas');

	}

	public function checkCode(){
		$CI = &get_instance();
		$CI->load->model('captcha_model');
		$CI->load->library('my_session');

		$key = $CI->my_session->userdata('captchaKey');
		$code = $CI->input->post('captcha');
		if(isset($key) && isset($code)){
			$getCaptcha = $CI->captcha_model->getCode($key);
			if($getCaptcha === NULL){
				// captcha has expired
				return NULL;
			} 
			if($getCaptcha['characters'] == $CI->input->post('captcha')){
				// captcha matches that in database, success!
				$CI->my_session->unset_userdata('captchaKey');
				return TRUE;
			} else {
				return FALSE;
			}
		}
	}

	public function captchaCode(){
		$randKey = '';
		for($i = 0; $i < rand(10,20); $i++){
			$randKey .= rand(1,999);
		} 
		return md5($randKey);
	}

	public function generateCaptcha($length='5'){
		$CI = &get_instance();
		$CI->load->model('captcha_model');
		$CI->load->library('my_session');
		$CI->load->helper('captcha');
		$CI->load->helper('url');

		/* list all possible characters, similar looking characters and vowels have been removed */
		$possible = '23456789bcdfghjkmnpqrstvwxyz';
		$characters = '';
		$i = 0;
		// create a captcha based on supplied length.
		while ($i < $length){
			$characters .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}

		// Array to pass to CI captcha helper.
		$arraycaptcha = array(		'word' => $characters,
						'img_path' => './assets/captcha/',
						'img_url' => base_url().'/assets/captcha/',
						'font_path' => './assets/font.ttf'
					);

		$captcha = create_captcha($arraycaptcha);

		$data = array();
		$data['image'] = $captcha['image'];
		$data['randomKey'] = $this->captchaCode();

		// Store captchaKey in a session, instead of tracking by IP.
		$CI->my_session->set_userdata('captchaKey',$data['randomKey']);

		// Add the solution to the captcha to the database.
		$CI->captcha_model->setCaptcha($data['randomKey'],$characters);

		return $data;

	}


};
