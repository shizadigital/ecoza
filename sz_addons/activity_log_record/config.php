<?php
defined('BASEPATH') OR exit('No direct script access allowed');

return [
	'ADDONS_NAME'				=> ['id_ID'=> 'Log Aktifitas', 'en_US' => 'Log Activity'], 
	'ADDONS_DESCRIPTION'		=> 'Rekaman/Log aktifitas pada CMS Shiza',
	'ADDONS_VERSION_NAME'		=> '1.0',
	'ADDONS_VERSION_CODE'		=> 1,
	'ADDONS_AUTHOR'				=> 'Shiza Digital',
	'ADDONS_AUTHOR_URL'			=> 'https://shiza.id/',
	'ADDONS_DOCUMENTATION_URL'	=> 'https://shiza.id/',

	'ADDONS_MENU_NUMBER'		=> 2,
	'ADDONS_MENU_ICON'			=> NULL,

	'ADDONS_MENU_CHILD_IN'		=> 'System', 

	/**
	 *  privilage addons
	 */
	'ADDONS_PRIVILEGE' 			=> ['view'=> 'y', 'add' => 'n', 'edit' => 'y', 'delete' => 'y']
];
