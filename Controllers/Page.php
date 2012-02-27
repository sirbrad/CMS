<?php
/** Load these in order of importance **/
$_router = Router::getInstance (); 
$_templater = Templater::getInstance ();
$_db = DB_Class::getInstance ();

$template = 'Templates/generic';

$method = $_router->get_controller_method ();
$value = $_router->get_method_value ();

/** Set up default page tags **/
$tags['alert'] = ' ';
$tags['directory'] = DIRECTORY;
$tags['site_name'] = SITE_NAME;
$tags['page_header'] = !!$value ? ucwords ( $value ) : ucwords ( $method );
$tags['script'] = 'main';
$tags['add_another'] = FALSE;

$_fb = new Form_builder_model( $method );

$tags['text_inputs'] = $_fb->get_textinputs();
$tags['text_areas'] = $_fb->get_textareas();
$tags['image_upload'] = $_fb->get_imageuploads();

$_templater->set_content ( $template, $tags );
?>
