<?php
/** Load these in order of importance **/
$_router = Router::getInstance (); 
$_templater = Templater::getInstance ();
$_db = DB_Class::getInstance ();

/** Page attributes default **/
$tags['alert'] = ' ';
$tags['directory'] = DIRECTORY;
$tags['site_name'] = SITE_NAME;
$tags['script'] = 'main';
$tags['show_add'] = FALSE;

$template = 'listing';

$list_type = $_router->get_controller_method ();

if ( $list_type == 'news' )
{
	$tags['edit_page'] = 'news/edit';
	$tags['show_add'] = TRUE;
	$table = 'news';
	$order_by = 'news_date DESC';
}

/** Initiate the list model and build the result list **/
$listing = new Listing_model;
$params = array ( 'table' => $table, 'order_by' => $order_by );
list ( $tags['results'], $response ) = $listing->init ( $params );

if ( !!$response )
	$tags['alert'] = $response;

/** Then load the view **/
$template = 'Templates/' . $template;
$_templater->set_content ( $template, $tags );

?>
