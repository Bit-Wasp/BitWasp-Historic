
<?php

class My_session extends CI_Session {

	public function checkAuth(){
		$CI = &get_instance();
		$CI->load->library('general');
		// check user is allowed to view the page
		// for now, determined by the first URI string.
		$URI = explode("/", uri_string());
		$level = $CI->general->getAuthLevel($URI[0]);


		if($level == 'login'){
			// Page requires login, check the session.
			if( $CI->session->userdata('logged_in') == true )
				return true;
		}
		if($level == 'vendor'){
			// Page requires a vendor, check the userRole for admin/vendor
			if( 	strtolower($CI->session->userdata('userRole')) == 'admin' 	
			||	strtolower($CI->session->userdata('userRole')) == 'vendor' 	)
				return true;
		}
		if($level == 'admin'){ 
			// PAge requires an admin, check the role for admin
			if(	strtolower($CI->session->userdata('userRole')) == 'admin')
				return true;
		}
		if($level == 'buyer'){
			// Page requires a buyer, allow admin/buyer by role.
			if(	strtolower($CI->session->userdata('userRole')) == "admin"
			||	strtolower($CI->session->userdata('userRole')) == "buyer" )
			return true;
		}	
		if($level == FALSE)	// Default: allow the user onto the page.  - should be globalized.
			return true;
			
		redirect('error/forbidden');
	}				

        public function __construct(){
                parent::__construct();
                $CI = &get_instance();
		$CI->load->library('session');
                $CI->load->model('users_model');
		$CI->load->model('sessions_model');
		$CI->load->model('pages_model');

		if($CI->session->userdata('logged_in') === TRUE){
			// User logged in, load the info for the session.
			$userHash = $CI->session->userdata('userHash');
                        $sessionInfo = $CI->sessions_model->getInfo($userHash);
			// Check if the user's session has timed out.
                        if(time()-$sessionInfo['last_activity'] > 1800){		// activity - should be globalized
                                // half an hour before time out 
				// Kill session and redirect to the inactivity login page.
                                $this->killSession($userHash);
                                redirect('users/logoutInactivity');
                        } else {
				// Otherwise, update the session in the table, will create the entry if needed.
                                $CI->sessions_model->updateSession($userHash);
                        }
		}
		// Check the auth required for the user to view the page.
		$this->checkAuth();
	}	

	// Create a new session
        public function createSession($user, $twoStep = FALSE){
                $CI = &get_instance();
		// Set the user session.
		if($twoStep == TRUE){
			$sessionData = array(	'id' => $user['id'],
						'twoStep' => TRUE
					);
		} else {
			if($CI->session->userdata('twoStep') !== NULL)
				$CI->session->unset_userdata('twoStep');
			

                	$sessionData = array( 	'id' => $user['id'],
						'userHash' => $user['userHash'],
                                	        'userRole' => $user['userRole'],
                                        	'logged_in' => TRUE,
	                                        'last_activity' => time()
        	                            );
		}
                $CI->session->set_userdata($sessionData);

        }

	// Kill user session
        public function killSession(){
                $CI = &get_instance();

		// Delete session from the database
                $CI->sessions_model->killSession($CI->session->userdata('userHash'));
		// Unset all session variables.
		$CI->session->unset_userdata('id');
                $CI->session->unset_userdata('userHash');
                $CI->session->unset_userdata('userRole');
                $CI->session->unset_userdata('logged_in');
                $CI->session->unset_userdata('last_activity');
                $CI->session->unset_userdata('twoStep');
		// Destroy the session.
                session_destroy();
        }

}

