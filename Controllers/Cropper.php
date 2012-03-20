<?php
$_router = Router::getInstance (); 
$_men = new Menu_model();
$_templater = Templater::getInstance ();
$_arr = new Arrays;

$method = $_router->get_controller_method ();

$tags['styles'] = $_arr->mutli_one_dimension ( array ( 'cropper' ), 'stylesheet' );
$tags['side_menu'] = $_men->get_menu();
$tags['directory'] = DIRECTORY;
$tags['script'] = 'main';
$tags['image'] = $method;

$template = 'Templates/cropper';
$_templater->set_content ( $template, $tags );
?>