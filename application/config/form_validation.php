<?php
$config = array(
		'register'	=>	array(
						array(	'field' => 'username',
							'label' => 'Username',
							'rules' => 'xss_clean|trim|alpha_dash|required|min_length[5]|is_unique[users.userName]'
							),
						array( 	'field' => 'password0',
							'label' => 'Password',
							'rules' => 'trim|required'
							),
						array(	'field' => 'password1',
							'label' => 'Password Confirmation',
							'rules' => 'trim|required|matches[password0]'
							),
						array(	'field' => 'usertype',
							'label' => 'Role',
							'rules' => 'callback_register_check_role'
							),
                                                array( 'field' => 'captcha',
                                                        'label' => 'Captcha',
                                                        'rules' => 'trim|required|callback_check_captcha'
                                                        )

					),
		'login'		=>	array(
						array(	'field' => 'username',
							'label' => 'Username',
							'rules' => 'trim|required'
							),
						array(	'field' => 'password',
							'label' => 'Password',
							'rules' => 'required'
							),
						array( 'field' => 'captcha',
							'label' => 'captcha',
							'rules' => 'trim|required|callback_check_captcha'
							)
					)


		);

