<?php
/** Load these in order of importance **/
$_router = Router::getInstance (); // Routes the uri
$_db = DB_Class::getInstance (); // Use this if you want a database connection
$_templater = Templater::getInstance (); // Load this if you want the templater

include ( 'App/Helpers/Common.php' );

$tags['directory'] = DIRECTORY;

$tags['include_banana'] = get_include ( 'header' );

$template = 'index';

$method = $_router->get_controller_method ();

$_templater->set_content ( $template, $tags );

?>