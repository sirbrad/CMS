<?php
/** Load these in order of importance **/
$_router = Router::getInstance (); 
$_templater = Templater::getInstance ();

$_men = new Menu_model();
$tags['side_menu'] = $_men->get_menu();

/** Page attributes default **/
$tags['alert'] = ' ';
$tags['directory'] = DIRECTORY;
$tags['site_name'] = SITE_NAME;
$tags['script'] = 'main';

$tags['show_add'] = TRUE;

$template = 'listing';

$list_type = $_router->get_controller_method ();


if ( $list_type == 'dynamic' )
{
	$list_type = $_router->get_method_value ();
	$tags['edit_page'] = 'page/' . $list_type . '/';
}
else
{
	$tags['edit_page'] = $list_type.'/edit';
}


$table = $list_type;
$order_by = $table.'_date DESC';

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
