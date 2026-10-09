
<?php
defined('BASEPATH') OR exit('No direct script access allowed');



$route['page/(:any)'] 							= 'main/index/$1';
$route['auth/(:any)'] 							= 'main/auth/$1';
$route['route/(:any)'] 							= 'main/$1';
$route['modal/(:any)'] 							= 'main/modal/$1';
$route['adminmodal/(:any)'] 				= 'main/adminmodal/$1';
$route['secure']				 						= 'main/secure/index';
$route['search']				 						= 'main/index/search';
$route['secure/(:any)']				 			= 'main/secure/$1';
$route['submateri/(:any)']				 	= 'main/index/submateri/$1';
$route['edit_page/(:any)']				 	= 'main/edit/$1';
$route['new_page/(:any)']				 	  = 'main/edit/$1/new';
$route['admindata/(:any)'] 					= 'main/postdataadmin/adminmodel/$1';
$route['maindata/(:any)'] 					= 'main/postdata/mainmodel/$1';
$route['userpay/(:any)'] 					  = 'payment/$1';
$route['userpay/(:any)/(:any)'] 	  = 'payment/$1/$2';

$route['userdata/(:any)'] 					= 'main/postdata/usermodel/$1';
$route['routes/(:any)/(:any)'] 			= 'main/$1/$2';
$route['page/(:any)/(:any)'] 				= 'main/index/$1/$2';
$route['page'] 											= 'main/index/index';

$route['default_controller'] = 'main/index';
$route['404_override'] = 'main/empatkosongempat';
$route['translate_uri_dashes'] = FALSE;
