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

$query = 'SELECT * FROM cms_news ORDER BY news_title ASC';

$query = $_db->get ( $query );

$results = array ();

foreach ( $query as $row )
{
	$results[] = array ( 'news_title' => $row['news_title'],
						 'news_date' => date ( 'd/m/Y', strtotime( $row['news_date'] ) ) );
}

$tags['results'] = $results;



$template = 'Templates/listing';
$_templater->set_content ( $template, $tags );

?>
