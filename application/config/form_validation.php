<?php
$config = array(		
		'addCategory'	=>	array(
						array(	'field' => 'name',
							'label' => 'name',
							'rules' => 'trim|required|min_length[2]|strip_tags|is_unique[categories.name]'
							),
						array(	'field' => 'description',
							'label' => 'description',
							'rules' => 'required|strip_tags'
							),
						array(	'field' => 'parentID',
							'label' => 'parent category',
							'rules' => 'required|numeric|callback_check_parentID_exists'
							)
					),

		'editAccount'	=>	array(
						array(	'field' => 'passwordConfirm',
							'label' => 'Password Confirmation',
							'rules' => 'required'
							),
						array(	'field' => 'twoStep',
							'label' => 'Two Step Authenication',
							'rules' => 'required|numeric'
							),
						array(	'field' => 'profileMessage',
							'label' => 'Profile Message',
							'rules' => 'htmlentities|trim|required'
							)
					),
		'addItem'	=> 	array(
						array( 'field' => 'name',
							'label' => 'item name',
							'rules' => 'required|strip_tags'		
							),
						array( 'field' => 'description',
							'label' => 'description',
							'rules' => 'required|strip_tags'		
							),
						array( 'field' => 'categoryID',
							'label' => 'category',
							'rules' => 'required|callback_check_category_exists'		
							),
						array( 'field' => 'price',
							'label' => 'price',
							'rules' => 'required|trim|decimal'		
							)
					),
		'editItem'	=> 	array(
						array( 'field' => 'name',
							'label' => 'Item Name',
							'rules' => 'required|strip_tags'		
							),
						array( 'field' => 'description',
							'label' => 'Description',
							'rules' => 'required|strip_tags'		
							),
						array( 'field' => 'categoryID',
							'label' => 'Category',
							'rules' => 'required|callback_check_category_exists'		
							),
						array( 'field' => 'price',
							'label' => 'Price',
							'rules' => 'required|trim|decimal'		
							)
					),
		'removeCategory'=>	array(
						array(	'field' => 'categoryID',
							'label' => 'Category ID',
							'rules' => 'required|callback_check_category_exists'
							)
					),

		'addImage'	=>	array(
						array(	'field' => 'userfile',
							'label' => 'Image File',
							'rules' => 'required'
							)
					),
		'uploadImage'	=>	array(
						array(	'field' => 'userfile',
							'label' => 'Image File',
							'rules' => 'required'
							)
					),
		'fixOrphanCategories'=>	array(
						array(	'field' => 'categoryID',
							'label' => 'Category ID',
							'rules' => 'required|callback_check_category_exists'
							)
					),
		'register'	=>	array(
						array(	'field' => 'username',
							'label' => 'username',
							'rules' => 'trim|required|alpha_dash|min_length[5]|is_unique[users.userName]'
							),
						array( 	'field' => 'password0',
							'label' => 'password',
							'rules' => 'trim|required'
							),
						array(	'field' => 'password1',
							'label' => 'Password Confirmation',
							'rules' => 'trim|matches[password0]'
							),
						array(	'field' => 'usertype',
							'label' => 'role',
							'rules' => 'callback_register_check_role'
							),
                                                array( 'field' => 'captcha',
                                                        'label' => 'captcha',
                                                        'rules' => 'trim|required|callback_check_captcha'
                                                        )
					),
		'login'		=>	array(
						array(	'field' => 'username',
							'label' => 'username',
							'rules' => 'trim|required'
							),
						array(	'field' => 'password',
							'label' => 'password',
							'rules' => 'required'
							),
						array( 'field' => 'captcha',
							'label' => 'captcha',
							'rules' => 'required|callback_check_captcha'
							)
					),

		'twoStep'	=>	array(	
						array(	'field' => 'solution',
							'label' => 'token',
							'rules' => 'trim|required'
							)
					),
		'sendmessage'	=>	array(
						array(	'field' => 'recipient',
							'label' => 'Recipient',
							'rules' => 'trim|required|callback_check_user_exists'
							),
						array(	'field' => 'subject',
							'label' => 'Subject',
							'rules' => 'trim|required|strip_tags'
							),
						array( 'field' => 'message',
							'label' => 'message',
							'rules' => 'trim|htmlentities|required'
							)
					),

		'reviewOrder' => 	array(
						array(	'field' => 'comment',
							'label' => 'Comment',
							'rules' => 'trim|htmlentities|required'

						),
						array(	'field' => 'rating',
							'label' => 'Rating',
							'rules' => 'numeric|required|callback_check_rating'
						)
					)

		);

