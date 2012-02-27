<?php
/** Load these in order of importance **/
$_router = Router::getInstance (); 
$_templater = Templater::getInstance ();
$_db = DB_Class::getInstance ();
$_fb = new Form_builder_model;

$_db_columns = $_fb->get_table_cols ( 'blog' );

foreach ( $_db_columns as $_col )
	$tags[ $_col ] = ' ';

$template = 'Templates/blog';

$method = $_router->get_controller_method ();
$value = $_router->get_method_value ();

/** Set up default page tags **/
$tags['alert'] = ' ';
$tags['directory'] = DIRECTORY;
$tags['site_name'] = SITE_NAME;
//$tags['script'] = 'main';
$tags['add_another'] = FALSE;

$attributes = array ( 'table' => 'blog', 
					  'columns' => $_db_columns, 
					  'id_column' => 'blog_id' );
					  
$data_mod = new Data_model;

list ( $_tags, $_id ) = $data_mod->init ( $attributes, $tags );

if ( !!$_id )
{
	$tags['hidden_id'] = $_id;
	$tags['add_another'] = TRUE;
}
else
	$tags['hidden_id'] = ' ';	

$tags = array_merge ( $tags, $_tags );	


$_templater->set_content ( $template, $tags );
?>
