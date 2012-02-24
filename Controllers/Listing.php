<?php
/** Load these in order of importance **/
$_router = Router::getInstance (); 
$_templater = Templater::getInstance ();
$_db = DB_Class::getInstance ();

include ( 'App/Helpers/Common.php' );

/** Page attributes default **/
$tags['include_header'] = get_include ( 'header' );
$tags['alert'] = ' ';
$tags['directory'] = DIRECTORY;
$tags['site_name'] = SITE_NAME;
$tags['script'] = 'main';

$tags['edit_page'] = 'news/edit';

$listing = new Listing_model;

$params = array ( 'table' => 'news' );

$tags['results'] = $listing->init ( $params );

$template = 'Templates/listing';
$_templater->set_content ( $template, $tags );

?>
