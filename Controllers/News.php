<?php
/** Load these in order of importance **/
$_router = Router::getInstance (); // Routes the uri
$_templater = Templater::getInstance (); // Load this if you want the templater

// Standard tags that should be set
$tags['alert'] = ' ';
$tags['directory'] = DIRECTORY;
$tags['site_name'] = SITE_NAME;
$tags['script'] = 'main';
$tags['add_another'] = FALSE;

// Set up the stylesheets dynamically
$_arr = new Arrays;
$tags['styles'] = $_arr->stylesheets ( 'style1,style2' );

// Set up the database columns at the start - used for saving and whatever
$db_columns = array ( 'news_title',
					  'news_content',
					  'news_imgname',
					  'news_link',
					  'news_twitter',
					  'news_on',
					  'news_dropdowns' );

// Set the tags in the view to nothing until assigned.
// This means we do not need to views for adding and editing! 
foreach ( $db_columns as $_col )
	$tags[ $_col ] = ' ';

// The template to view - this can change depending on the controller method.
$template = 'Templates/example_news';

// Get the uri values/parameters
$method = $_router->get_controller_method ();
$value = $_router->get_method_value ();

$attributes = array ( 'table' => 'news', 
					  'columns' => $db_columns, 
					  'id_column' => 'news_id' );

// This is to show the different types of application views you can have,
// Just determined by the uri segment.
if ( $method == 'edit' && !!$value )
{
	$attributes['id'] = $value;
	$tags['switch'] = '<p>You are viewing the editing view!</p>';
	$tags['add_another'] = TRUE;
}
elseif ( $method == 'add' || !isset ( $value ) ) 
{
	$tags['switch'] = '<p>You are viewing the adding view</p>';
}

$data_mod = new Data_model;

list ( $_tags, $_id ) = $data_mod->init ( $attributes, $tags );

$tags['dropdowns'] = $data_mod->get_widgets ( 'dropdowns', 'news' );

$tags['dropdowns2'] = $data_mod->get_widgets ( 'dropdowns', 'news' );


if ( !!$_id )
{
	$tags['hidden_id'] = $_id;
	$tags['add_another'] = TRUE;
}
else
	$tags['hidden_id'] = ' ';	

$tags = array_merge ( $tags, $_tags );	


// This loads the view. Have to have this method to load the view
$_templater->set_content ( $template, $tags );

?>