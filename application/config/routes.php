<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

//Redirect to product listing and individual product page
$route['listings'] = 'listings/index';


$route['users'] = 'users';
$route['users/login'] = 'users';
$route['users/logout'] = 'users/logout';
$route['users/register'] = 'users/register';
$route['users/logoutInactivity'] = 'users/logoutInactivity';

// Show show specific products, and all.
$route['product/(:any)'] = 'products/view/$1';
$route['products'] = 'products';

// Error class
$route['error/forbidden'] = 'error/forbidden';

// Display a particular user
//$route['user'] = 'user/me';
$route['user/(:any)'] = 'user/view/$1';

//Show products under a particular category
$route['cat/(:any)'] = 'products/cat/$1';

$route['home/(:any)'] = 'home/index/$1';

// Admin panel, yet to be added
$route['admin'] = 'admin/dashboard';

//Redirect pages as default
$route['default_controller'] = 'users';
$route['(:any)'] = 'pages/view/$1';

$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
