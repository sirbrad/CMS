<?php
/** Load these in order of importance **/
$_router = Router::getInstance (); 
$_templater = Templater::getInstance ();
$_db = DB_Class::getInstance ();
$_men = new Menu_model();
$tags['side_menu'] = $_men->get_menu();

$template = 'Templates/generic';

$method = $_router->get_controller_method ();
$value = $_router->get_method_value ();

/** Set up default page tags **/
$tags['alert'] = ' ';
$tags['directory'] = DIRECTORY;
$tags['table'] = $method;
$tags['site_name'] = SITE_NAME;
$tags['page_header'] = !!$value ? ucwords ( str_replace ( "_", " ", $value ) ) : ucwords ( str_replace ( "_", " ", $method ) );
$tags['script'] = 'main';
$tags['add_another'] = FALSE;

$_fb = new Form_builder_model( $method );

$tags['text_inputs'] = $_fb->get_textinputs();
$tags['text_areas'] = $_fb->get_textareas();
$tags['image_upload'] = $_fb->get_imageuploads();
$tags['show_dropdowns'] = $_fb->get_dropdowns();
$tags['show_downloads'] = $_fb->get_downloads();


$_templater->set_content ( $template, $tags );
?>
