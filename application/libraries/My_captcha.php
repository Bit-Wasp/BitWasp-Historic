<?php

class My_captcha {

	public function __construct(){
		$CI = &get_instance();
		// Delete captcha's over two hours old
		$CI->db->where('time <',time()-7200);
		$CI->db->delete('captchas');
		$CI->load->library('my_image');

	}

	// Check that the submission is correct.
	public function checkCode($code){
		$CI = &get_instance();
		$CI->load->model('captcha_model');

		// Obtain captcha's key from the users session.
		$key = $CI->my_session->userdata('captchaKey');

		// Check the key and code is set
		if(isset($key) && isset($code)){

			// If so, load the captcha with the captcha key.
			$getCaptcha = $CI->captcha_model->getCode($key);

			// If it can't be found, captcha has expired.
			if($getCaptcha === NULL){
				// Failure; captcha expired.
				return FALSE;
			} 

			if($getCaptcha['characters'] == $CI->input->post('captcha')){
				// Success: matches that in the database.
				// Remove captchaKey and return TRUE.
				$CI->my_session->unset_userdata('captchaKey');
				return TRUE;
			} else {
				// Failure; Captcha does not match.
				return FALSE;
			}
		} else {
			// Failure; captcha key/code not set - captcha needs to be created.
			return FALSE;
		}
	}

	// Generate a captcha.
	public function generateCaptcha($length='5'){
		$CI = &get_instance();
		$CI->load->model('captcha_model');
		
		$CI->load->helper('captcha');
		$CI->load->helper('url');

		// list all possible characters, similar looking characters and vowels have been removed 
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
						'img_path' => 'assets/images/captcha/',
						'img_url' => base_url().'assets/images/captcha/',
						'font_path' => 'assets/font.ttf',
            'img_width' => '218'
					);

		// create captcha from the array above
		$captcha = create_captcha($arraycaptcha);

		// prepare data[] for the view
		$data = array();

		// No need to add captchas to the image DB. They are automatically cleared, and displayed only once.
		$data['image'] = $CI->my_image->displayTempImage("captcha/{$captcha['time']}.jpg");

		$data['randomKey'] = $CI->general->uniqueHash('captchas','key');

		// Remove the image after it has been displayed. 
		unlink("assets/images/captcha/{$captcha['time']}.jpg");

		// Store captchaKey in a session rather than in the DB by ip. Identifies the captcha solution
		$CI->my_session->set_userdata('captchaKey',$data['randomKey']);

		// Add the solution to the captcha to the database.
		$CI->captcha_model->setCaptcha($data['randomKey'],$characters);

		return $data;

	}


};
