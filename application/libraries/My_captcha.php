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

		if(isset($key) && isset($code)){
			$getCaptcha = $CI->captcha_model->getCode($key);
			if($getCaptcha === NULL){
				// captcha has expired
				return FALSE;
			} 
			if($getCaptcha['characters'] == $CI->input->post('captcha')){
				// captcha matches that in database, success!
				$CI->my_session->unset_userdata('captchaKey');
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
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
						'img_path' => 'assets/images/captcha/',
						'img_url' => base_url().'assets/images/captcha/',
						'font_path' => 'assets/font.ttf'
					);

		// create captcha from the array above
		$captcha = create_captcha($arraycaptcha);

		// prepare data[] for the view
		$data = array();

		// No need to add captchas to the image DB. They are automatically cleared, and displayed only once.
		$data['image'] = $CI->my_image->displayTempImage("captcha/{$captcha['time']}.jpg");
		$data['randomKey'] = $this->captchaCode();
		unlink("assets/images/captcha/{$captcha['time']}.jpg");
		// Store captchaKey in a session rather than in the DB by ip. Identifies the captcha solution
		$CI->my_session->set_userdata('captchaKey',$data['randomKey']);

		// Add the solution to the captcha to the database.
		$CI->captcha_model->setCaptcha($data['randomKey'],$characters);

		return $data;

	}


};
