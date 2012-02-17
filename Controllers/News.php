<?php
/** Load these in order of importance **/
$_router = Router::getInstance (); // Routes the uri
$_db = DB_Class::getInstance (); // Use this if you want a database connection
$_templater = Templater::getInstance (); // Load this if you want the templater

include ( 'App/Helpers/Common.php' );

$tags['include_header'] = get_include ( 'header' );
$tags['directory'] = DIRECTORY;
$tags['site_name'] = SITE_NAME;


$template = 'Templates/example_news';

$method = $_router->get_controller_method ();

if ( $method == 'edit' )
{
	$mod = new News_model ();
	
	$value = $_router->get_method_value ();
	
	$_tags = $mod->get_values ( $value );
	
	array_merge ( $_tags, $tags );
	
	die ( print_r ( $tags ) );
	
}

$_templater->set_content ( $template, $tags );

?>