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
$route['default_controller'] = 'admin_control/index';
$route['404_override'] = '';

/*admin*/
$route['admin'] = 'admin_control/index';
$route['admin/signup'] = 'admin_control/signup';
$route['admin/create_member'] = 'admin_control/create_member';
$route['admin/login'] = 'admin_control/index';
$route['admin/logout'] = 'admin_control/logout';
$route['admin/login/validate_credentials'] = 'admin_control/validate_credentials';

$route['admin/users'] = 'admin_users/index';
$route['admin/users/add'] = 'admin_users/add';
$route['admin/users/update'] = 'admin_users/update';
$route['admin/users/update/(:any)'] = 'admin_users/update/$1';
$route['admin/users/delete/(:any)'] = 'admin_users/delete/$1';
$route['admin/users/(:any)'] = 'admin_users/index/$1'; //$1 = page number

$route['admin/courses'] = 'admin_courses/index';
$route['admin/courses/add'] = 'admin_courses/add';
$route['admin/courses/update'] = 'admin_courses/update';
$route['admin/courses/update/(:any)'] = 'admin_courses/update/$1';
$route['admin/courses/delete/(:any)'] = 'admin_courses/delete/$1';
$route['admin/courses/(:any)'] = 'admin_courses/index/$1'; //$1 = page number



/* End of file routes.php */
/* Location: ./application/config/routes.php */