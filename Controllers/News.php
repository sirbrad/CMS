<?php
/** Load these in order of importance **/
$_router = Router::getInstance (); // Routes the uri
$_db = DB_Class::getInstance (); // Use this if you want a database connection
$_templater = Templater::getInstance (); // Load this if you want the templater

// Include any files or helpers needed
include ( 'App/Helpers/Common.php' );

// This can just go in the header really - but an example of how to load an include
$tags['include_header'] = get_include ( 'header' );

// Standard tags that should be set
$tags['directory'] = DIRECTORY;
$tags['site_name'] = SITE_NAME;

// Set up the database columns at the start - used for saving and whatever
$db_columns = array ( 'news_title',
					  'news_content',
					  'news_link',
					  'news_twitter',
					  'news_on' );

// Set the tags in the view to nothing until assigned.
// This means we do not need to views for adding and editing! 
foreach ( $db_columns as $_col )
	$tags[ $_col ] = '';

// The template to view - this can change depending on the controller method.
$template = 'Templates/example_news';

$method = $_router->get_controller_method ();

// Pick up the controller method - this time edit.
if ( $method == 'edit' )
{
	// Load the relevent model that you want
	$mod = new News_model ();
	
	$value = $_router->get_method_value ();
	
	$_tags = $mod->get_values ( $value );
	
	// As the model gathered up tags we merge the two tag arrays to display
	$tags = array_merge ( $tags, $_tags );
	
}


$_templater->set_content ( $template, $tags );

?>