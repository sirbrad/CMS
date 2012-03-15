<?php
/** Load these in order of importance **/
$_router = Router::getInstance (); 
$_men = new Menu_model();
$_arr = new Arrays;
$data_mod = new Data_model;
$_templater = Templater::getInstance ();

/** Get the method and value from the URI **/
$method = $_router->get_controller_method ();
$value = $_router->get_method_value ();

/** Set up default page tags **/
$tags['side_menu'] = $_men->get_menu();
$tags['alert'] = ' ';
$tags['directory'] = DIRECTORY;
$tags['table'] = $method;
$tags['site_name'] = SITE_NAME;
$tags['page_header'] = ucwords ( str_replace ( "_", " ", $method ) );
$tags['add_another'] = FALSE;
$tags['show_dropdowns'] = FALSE;
$tags['show_downloads'] = FALSE;
$tags['show_image'] = FALSE;
$tags['hidden_id'] = ' ';
$tags['input_title_value'] = ' ';
$tags['input_content_value'] = ' ';
$tags['input_url_value'] = ' ';
$tags['hidden_imgname_value'] = ' ';
$tags['images'] = ' ';
$tags['multiple_upload'] = ' ';

/** Assign the main page attributes i.e table name, view file and script **/
$table = $method;
$template = 'Templates/generic';
$tags['script'] = 'main';
$tags['table_ref'] = $table;

/** Set up the form attributes from this point **/
$_fb = new Form_builder_model( $method );

$tags['text_inputs'] = $_fb->get_textinputs();
$tags['text_areas'] = $_fb->get_textareas();
$tags['url_inputs'] = $_fb->get_urlinputs();
$tags['image_upload'] = $_fb->get_imageuploads();
$tags['show_dropdowns'] = $_fb->get_dropdowns();
$tags['show_downloads'] = $_fb->get_downloads();

// If the page has image insert the upload css file.
if ( !!$tags['image_upload'] )
	$tags['styles'] = $_arr->mutli_one_dimension ( array ( 'upload' ), 'stylesheet' );

if ( $tags['show_dropdowns'] )
	$tags['dropdowns'] = $data_mod->get_widgets ( 'dropdowns', $table );
	
if ( $tags['show_downloads'] )
	$tags['downloads'] = $data_mod->get_widgets ( 'downloads', $table );
	
if ( !!$tags['image_upload'] )
	$tags['show_image'] = TRUE;
	
	

/** Set up the database handling and columns from here **/

$_db_columns = $_fb->get_table_cols ( $table );

if ( in_array ( $table.'_image_multiple', $_db_columns ) )
	$tags['multiple_upload'] = 'multiple="true"';

// Set all the columns to default to empty
foreach ( $_db_columns as $_col )
	$tags[ $_col ] = ' ';
	
$attributes = array ( 'table' => $table, 
					  'columns' => $_db_columns, 
				      'id_column' => $table.'_id',
					  'id' => $value );
					  
list ( $_tags, $_id ) = $data_mod->init ( $attributes, $tags );



/** Change the values not not target the table name but assign the values to a *generic* tag **/
foreach ( $_tags as $t => $v )
{
	// Replace the title tag value
	if ( $t == $table.'_title' && !!$v )
	{
		$tags['input_title_value'] = $v;
		unset ( $_tags[ $table.'_title'  ] );
	}
	
	// Replace the content tag value
	if ( $t == $table.'_content' && !!$v )
	{
		$tags['input_content_value'] = $v;
		unset ( $_tags[ $table.'_content' ] );
	}
	
	// Replace the url tag value
	if ( $t == $table.'_url' && !!$v )
	{
		$tags['input_url_value'] = $v;
		unset ( $_tags[ $table.'_url' ] );
	}
	
	// Replace the url tag value
	if ( $t == $table.'_imgname' && !!$v )
	{
		$tags['hidden_imgname_value'] = $v;
		unset ( $_tags[ $table.'_imgname' ] );
	}
}

// Set the hidden id if its been set
if ( !!$_id )
	$tags['hidden_id'] = $_id;

// Merge the tags
if ( !!$_tags )
	$tags = array_merge ( $tags, $_tags );
	


/** Load and display the actual page **/
$_templater->set_content ( $template, $tags );
?>
