<?php
/** Load these in order of importance **/
$_router = Router::getInstance (); // Routes the uri
$_db = DB_Class::getInstance (); // Use this if you want a database connection
$_templater = Templater::getInstance (); // Load this if you want the templater

include ( 'App/Helpers/Common.php' );

$tags['include_header'] = get_include ( 'header' );
$tags['directory'] = DIRECTORY;
$tags['site_name'] = SITE_NAME;


$template = 'Templates/example_news';

$method = $_router->get_controller_method ();

if ( $method == 'edit' )
{
	$value = $_router->get_method_value ();
	
	$query = $_db->get ( 'SELECT * FROM cms_news WHERE news_id = "' . $value . '"' );
	
	foreach ( $query as $rows )
	{
		foreach ( $rows as $key => $value )
		{
			if ( $value == 1 )
				$tags[ $key ] = ' checked';
			else
				$tags[ $key ] = $value;
		}
	}
}

$_templater->set_content ( $template, $tags );

?>