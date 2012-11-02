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

// User Logins
$route['users'] = 'users/login';
$route['users/login'] = 'users/login';
$route['users/logout'] = 'users/logout';
$route['users/register'] = 'users/register';
$route['users/logoutInactivity'] = 'users/logoutInactivity';
$route['users/twoStep'] = 'users/twoStep';
$route['users/registerPGP'] = 'users/registerPGP';

$route['bitcoin'] = 'bitcoin/index';

// Show show specific products, and all.
$route['items'] = 'items';
$route['items/item_count'] = 'items/tmp_items_per_page';
$route['items/(:any)'] = 'items/index/$1';
$route['item/(:any)'] = 'items/view/$1';
$route['item'] = 'items';

// Edit a sellers listings
$route['listings'] = 'listings/manage';
$route['listings/create'] = 'listings/create';
$route['listings/remove/(:any)'] = 'listings/remove/$1';
$route['listings/edit/(:any)'] = 'listings/edit/$1';
$route['listings/images/(:any)'] = 'listings/images/$1';
$route['listings/imageUpload/(:any)'] = 'listings/imageUpload/$1';
$route['listings/imageRemove/(:any)'] = 'listings/imageRemove/$1';
$route['listings/mainImage/(:any)'] = 'listings/mainImage/$1';

// Control a buyers orders
$route['orders'] = 'orders/index';
$route['orders/review/(:any)'] = 'orders/review/$1';
$route['order/place/(:any)'] = 'orders/place/$1';
$route['order/(:any)'] = 'orders/orderItem/$1';
$route['order/recount'] = 'orders/recount';

// Seller confirms a payment
$route['payment/confirm/(:any)'] = 'orders/confirmPayment/$1';
// Seller confirms item dispatch
$route['dispatch/confirm/(:any)'] = 'orders/confirmDispatch/$1';
$route['purchases'] = 'orders/purchases';

$route['account'] = 'account/index';
$route['account/edit'] ='account/edit';
$route['account/update'] ='account/update';
$route['account/deletePubKey'] = 'account/deletePubKey';
$route['account/replacePGP'] = 'account/replacePGP';
// Messages 
$route['messages'] = 'messages/inbox';
$route['messages/inbox'] = 'messages/inbox';
$route['message/delete/(:any)'] = 'messages/delete/$1';
$route['messages/send/(:any)'] = 'messages/send/$1';
$route['messages/send'] = 'messages/send';
$route['message/reply/(:any)'] = 'messages/send/$1';
$route['message/reply'] = 'messages/reply';
$route['message/(:any)'] = 'messages/read/$1';


// Error class
$route['error/(:any)'] = 'error/$1';

// Display a particular user
//$route['user'] = 'user/me';
$route['user/(:any)'] = 'users/view/$1';
// $route['user'] = 'users';

//Show products under a particular category
$route['cat/(:any)'] = 'items/cat/$1';

$route['home'] = 'home/index';

// Admin panel, yet to be added
$route['admin'] = 'admin/index';
$route['admin/category/add'] = 'admin/addCategory';
$route['admin/category/remove'] = 'admin/removeCategory';
$route['admin/category/fixOrphans'] = 'admin/fixOrphans';
$route['admin/siteConfig'] = 'admin/siteConfig';
$route['admin/editConfig'] = 'admin/editConfig';
$route['admin/updateConfig'] = 'admin/updateConfig';
$route['admin/users'] = 'admin/users';
$route['admin/user'] = 'admin/users';
$route['admin/user/(:any)'] = 'admin/users/$1';

//Redirect pages as default
$route['default_controller'] = 'users/login';
$route['(:any)'] = 'pages/view/$1';

$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
