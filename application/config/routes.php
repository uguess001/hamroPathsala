<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/


$route['(:any)'] = 'web/school/$1';
$route['(:any)/about'] = 'web/about';
$route['(:any)/news'] = 'web/news';
$route['(:any)/news-detail/(:num)'] = 'web/news_detail/$1';
$route['(:any)/notice'] = 'web/notice';
$route['(:any)/notice-detail/(:num)'] = 'web/notice_detail/$1';
$route['(:any)/holiday'] = 'web/holiday';
$route['(:any)/holiday-detail/(:num)'] = 'web/holiday_detail/$1';
$route['(:any)/events'] = 'web/events';
$route['(:any)/event-detail/(:num)'] = 'web/event_detail/$1';
$route['(:any)/galleries'] = 'web/galleries';
$route['(:any)/gallery-image/(:num)'] = 'web/gallery_image/$1';
$route['(:any)/teachers'] = 'web/teachers';
$route['(:any)/staff'] = 'web/staff';
$route['(:any)/faq'] = 'web/faq';
$route['(:any)/contact'] = 'web/contact';
$route['(:any)/admission-online'] = 'web/admission_online';
$route['(:any)/admission-form'] = 'web/admission_form';
$route['(:any)/page/(:any)'] = 'web/page/$1';

$route['(:any)/login'] = 'auth/login';
$route['(:any)/logout'] = 'auth/logout';
$route['(:any)/forgot'] = 'auth/forgot';
$route['(:any)/reset/(:any)'] = 'auth/reset/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
