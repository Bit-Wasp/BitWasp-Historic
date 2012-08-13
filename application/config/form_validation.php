<?php
$config = array(		
		'addCategory'	=>	array(
						array(	'field' => 'name',
							'label' => 'Name',
							'rules' => 'htmlentities|trim|alpha_dash|required|min_length[2]|is_unique[categories.name]'
							),
						array(	'field' => 'description',
							'label' => 'Description',
							'rules' => 'htmlentities|required'
							),
						array(	'field' => 'parentID',
							'label' => 'Parent ID',
							'rules' => 'required|numeric|callback_check_parentID_exists'
							)
					),
		'addItem'	=> 	array(
						array( 'field' => 'name',
							'label' => 'Item Name',
							'rules' => 'required|htmlentities'		
							),
						array( 'field' => 'description',
							'label' => 'Description',
							'rules' => 'required|htmlentites'		
							),
						array( 'field' => 'categoryID',
							'label' => 'Category',
							'rules' => 'required|callback_check_category_exists'		
							),
						array( 'field' => 'price',
							'label' => 'Price',
							'rules' => 'required|trim'		
							)
					),
		'editItem'	=> 	array(
						array( 'field' => 'name',
							'label' => 'Item Name',
							'rules' => 'required|htmlentities'		
							),
						array( 'field' => 'description',
							'label' => 'Description',
							'rules' => 'required|htmlentities'		
							),
						array( 'field' => 'categoryID',
							'label' => 'Category',
							'rules' => 'required|callback_check_category_exists'		
							),
						array( 'field' => 'price',
							'label' => 'Price',
							'rules' => 'required|trim|integer'		
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
							'label' => 'Username',
							'rules' => 'htmlentities|trim|alpha_dash|required|min_length[5]|is_unique[users.userName]'
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
							'rules' => 'trim|htmlentities|required'
							),
						array(	'field' => 'password',
							'label' => 'Password',
							'rules' => 'required'
							),
						array( 'field' => 'captcha',
							'label' => 'captcha',
							'rules' => 'trim|required|callback_check_captcha'
							)
					),

		'sendmessage'	=>	array(
						array(	'field' => 'recipient',
							'label' => 'Recipient',
							'rules' => 'trim|htmlentities|required|callback_check_user_exists'
							),
						array(	'field' => 'subject',
							'label' => 'Subject',
							'rules' => 'required'
							),
						array( 'field' => 'message',
							'label' => 'message',
							'rules' => 'trim|required'
							)
					)

		);

