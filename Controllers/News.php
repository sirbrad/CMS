<?php
/** Load these in order of importance **/
$_router = Router::getInstance (); // Routes the uri
$_templater = Templater::getInstance (); // Load this if you want the templater

// Include any files or helpers needed
include ( 'App/Helpers/Common.php' );

// This can just go in the header really - but an example of how to load an include
$tags['include_header'] = get_include ( 'header' );

// Standard tags that should be set
$tags['alert'] = ' ';
$tags['directory'] = DIRECTORY;
$tags['site_name'] = SITE_NAME;
$tags['script'] = 'uploader';

// Set up the database columns at the start - used for saving and whatever
$db_columns = array ( 'news_title',
					  'news_content',
					  'news_imgname',
					  'news_link',
					  'news_twitter',
					  'news_on' );

// Set the tags in the view to nothing until assigned.
// This means we do not need to views for adding and editing! 
foreach ( $db_columns as $_col )
	$tags[ $_col ] = ' ';

// The template to view - this can change depending on the controller method.
$template = 'Templates/example_news';

// Get the uri values/parameters
$method = $_router->get_controller_method ();
$value = $_router->get_method_value ();

$mod = new Data_model;

$attributes = array ( 'table' => 'news', 
					  'columns' => $db_columns, 
					  'id_column' => 'news_id', 
					  'id' => $value );

// Pick up the controller method - this time edit.
if ( $method == 'edit' && !!$value )
{
	$tags['switch'] = '<p>You are viewing the editing view!</p>';
}
elseif ( $method == 'add' || !isset ( $value ) ) // I have set this to an or, so that it indexes to 'add' if they do not provide it. 
{
	$tags['switch'] = '<p>You are viewing the adding view</p>';
}

$_tags = $mod->init ( $attributes );
$tags = array_merge ( $tags, $_tags );	


// This loads the view. Have to have this method to load the view
$_templater->set_content ( $template, $tags );

?>