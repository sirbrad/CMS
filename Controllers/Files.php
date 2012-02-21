<?php
/** Load these in order of importance **/
$_router = Router::getInstance (); 
$_templater = Templater::getInstance (); 

// Include any files or helpers needed
include ( 'App/Helpers/Common.php' );
$tags['include_header'] = get_include ( 'header' );

// Standard tags that should be set
$tags['directory'] = DIRECTORY;
$tags['site_name'] = SITE_NAME;
$tags['script'] = 'uploader';

/*
$_directories = new Directories;
$_directories->set_allowed ( array ( 'jpg', 'png', 'jpeg', 'gif' ) );
$files = $_directories->get_images ( $_SERVER['DOCUMENT_ROOT'] . '/' . DIRECTORY . '/Assets/Uploads/Images' );
*/

if ( !!$_POST )
{
	$img = new Image_uploader ();
	$image = $img->upload();
}

$_templater->set_content ( 'Templates/upload', $tags );

?>