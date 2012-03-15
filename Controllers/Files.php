<?php
/** Load these in order of importance **/
$_router = Router::getInstance (); 
$_templater = Templater::getInstance (); 
$_arr = new Arrays;
$tags['styles'] = $_arr->mutli_one_dimension ( array ( 'upload' ), 'stylesheet' );


// Standard tags that should be set
$tags['directory'] = DIRECTORY;
$tags['site_name'] = SITE_NAME;
$tags['script'] = 'main';

/*
$_directories = new Directories;
$_directories->set_allowed ( array ( 'jpg', 'png', 'jpeg', 'gif' ) );
$files = $_directories->get_images ( $_SERVER['DOCUMENT_ROOT'] . '/' . DIRECTORY . '/Assets/Uploads/Images' );
*/


$_templater->set_content ( 'Templates/upload', $tags );

?>