<?php
/** Load these in order of importance **/
$_router = Router::getInstance (); // Routes the uri
$_db = DB_Class::getInstance (); // Use this if you want a database connection
$_templater = Templater::getInstance (); // Load this if you want the templater

$tags['directory'] = DIRECTORY;

$method = $_router->get_controller_method ();

if ( $method == 'number_1' )
{
	$template = 'test';
	
	$tags['title'] = 'This is the title';
	$tags['first_tag'] = 'This is the first tag replaced';
	$tags['second_tag'] = 'anndddd this is the second tag replaced!';
}

if ( $method == 'number_2' )
{
	$template = 'test2';
	
	$tags['title'] = 'This is the second test title';
	$tags['first_tag'] = 'As you can see the first tag is again replaced';
	$tags['second_tag'] = 'anndddd so you can see the second tag is replaced!';
	
	$results = $_db->get( 'SELECT * FROM testing' );
	
	foreach ( $results as $row )
	{
		$res[] = array ( 'name' => $row[ 'name' ] );	
	}
	
	$tags['results'] = $res;
}

$_templater->set_content ( $template, $tags );

?>