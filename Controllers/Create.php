<?php
/** Load these in order of importance **/
$_router = Router::getInstance (); 
$_templater = Templater::getInstance ();
$_db = DB_Class::getInstance ();
$_fb = new Form_builder_model;
$_men = new Menu_model();

$tags['side_menu'] = $_men->get_menu();

$template = 'Templates/create';

$tags['alert'] = ' ';
$tags['directory'] = DIRECTORY;
$tags['site_name'] = SITE_NAME;
$tags['script'] = 'create-page';

if ( !!$_POST['save'] )
{
	$table_name = $_db->escape ( str_replace ( " ", "_", strtolower ( $_POST['name'] ) ) );
	
	$sql = 'CREATE TABLE ' . PROJECT . '_' . $table_name . ' ('; 
	
	$sql .= '' . $table_name .'_id' . ' INT UNSIGNED NOT NULL AUTO_INCREMENT,';
	
	unset ( $_POST['save'] );
	unset ( $_POST['name'] );
	
	foreach ( $_POST as $att => $value )
	{
		if ( $att != 'table' )
			if ( $att == 'content' )
				$sql .= '' . $table_name . '_' . 'content' . ' TEXT NOT NULL,';
			elseif ( $att == 'image' )
			{
				$sql .= '' . $table_name . '_' . 'imgname' . $num . ' VARCHAR( 150 ),';	
			}
			elseif ( $att == 'multiple' && $value == 'multiple' )
				$sql .= '' . $table_name . '_' . 'image_multiple' . $num . ' VARCHAR( 150 ) NULL,';
			elseif ( $att != 'img-no' )
				$sql .= '' . $table_name . '_' . $att . ' VARCHAR( 150 ) NOT NULL,';
	}
	
	$sql .= '' . $table_name . '_date TIMESTAMP NOT NULL,';
	
	$sql .= 'PRIMARY KEY ( ' . $table_name .'_id' . ' ) )';
	
	$_db->query ( $sql );
	
	header ( 'location: /' . DIRECTORY . '/page/' . $table_name . '' ); 
}

$_templater->set_content ( $template, $tags );

?>