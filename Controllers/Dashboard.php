<?php
/** Load these in order of importance **/
$_router = Router::getInstance (); 
$_templater = Templater::getInstance ();
$_db = DB_Class::getInstance ();

$template = 'Templates/dashboard';

$method = $_router->get_controller_method ();

/** Set up default page tags **/
$tags['alert'] = ' ';
$tags['directory'] = DIRECTORY;
$tags['site_name'] = SITE_NAME;
$tags['script'] = 'main';

$_templater->set_content ( $template, $tags );

?>