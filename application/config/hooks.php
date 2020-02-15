<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

  
$hook['post_controller_constructor'][] = array(  
        'class' => 'runFirstEnvironment',  
        'function' => 'runEnv',  
        'filename' => 'runFirstEnvironment.php',  
        'filepath' => 'hooks',
        );

$hook['post_controller_constructor'][] = array(  
        'class' => 'validationLicense',  
        'function' => 'license_handler',  
        'filename' => 'validationLicense.php',  
        'filepath' => 'hooks',
        );