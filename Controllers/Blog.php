<?php
/** Load these in order of importance **/
$_router = Router::getInstance (); 
$_templater = Templater::getInstance ();
$_db = DB_Class::getInstance ();
$_fb = new Form_builder_model;

$template = 'Templates/blog';

$method = $_router->get_controller_method ();
$value = $_router->get_method_value ();

$table = $method == 'categories' ? 'categories' : 'blog';

$_db_columns = $_fb->get_table_cols ( $table );

/** Set up default page tags **/
$tags['alert'] = ' ';
$tags['directory'] = DIRECTORY;
$tags['site_name'] = SITE_NAME;
$tags['script'] = 'main';
$tags['add_another'] = FALSE;
$tags['show_categories'] = FALSE;

foreach ( $_db_columns as $_col )
	$tags[ $_col ] = ' ';

$data_mod = new Data_model;

if ( $method == 'add' || $method == 'edit' )
{
	$attributes = array ( 'table' => $table, 
						  'columns' => $_db_columns, 
						  'id_column' => 'blog_id',
						  'id' => $value );
	
	list ( $_tags, $_id ) = $data_mod->init ( $attributes, $tags );
	
	$tags['categories'] = $data_mod->get_widgets ( 'categories', 'blog' );
	
	if ( sizeof ( $tags['categories'] ) > 0 )
		$tags['show_categories'] = TRUE;
		
}

if ( $method == 'categories' )
{
	$attributes = array ( 'table' => $table, 
						  'columns' => $_db_columns, 
						  'id_column' => 'categories_id',
						  'id' => $value );
						  
	list ( $_tags, $_id ) = $data_mod->init ( $attributes, $tags );
	
	$template = 'Templates/blog_categories';
}

if ( $method == 'listing' )
{
	$table = $value == 'categories' ? 'categories' : 'blog';
	
	$template = 'Templates/blog_listing';
	
	$tags['edit_page'] = $table == 'blog' ? 'blog/edit' : 'blog/categories';
	
	$tags['show_add'] = TRUE;
	
	$order_by = $table.'_date DESC';
	
	/** Initiate the list model and build the result list **/
	$listing = new Listing_model;
	
	$params = array ( 'table' => $table, 'order_by' => $order_by );
	
	list ( $tags['results'], $response ) = $listing->init ( $params );
	
	if ( !!$response )
		$tags['alert'] = $response;	
}

/** Set the hidden ID value for updating & display the add another header **/
if ( !!$_id && $method != 'listing' )
{
	$tags['hidden_id'] = $_id;
	$tags['add_another'] = TRUE;
}
else
	$tags['hidden_id'] = ' ';	

if ( !!$_tags )
	$tags = array_merge ( $tags, $_tags );

$_templater->set_content ( $template, $tags );
?>
