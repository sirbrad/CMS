<?php
/** Load these in order of importance **/
$_router = Router::getInstance (); 
$_templater = Templater::getInstance ();
$_men = new Menu_model();

/** Page attributes default **/
$tags['directory'] = DIRECTORY;
$tags['site_name'] = SITE_NAME;
$tags['script'] = 'main';
$tags['list_of_pages'] = $_men->get_menu();
$tags['side_menu'] = $_men->get_menu();

$tags['show_add'] = TRUE;

$template = 'listing-dynamic-pages';


$_templater->set_content ( 'Templates/'.$template, $tags );
?>
