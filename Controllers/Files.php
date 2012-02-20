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

$directory = $_SERVER['DOCUMENT_ROOT'] . '/' . DIRECTORY . '/Assets/Uploads/Images';

$allow = array ( 'jpg', 'png', 'jpeg', 'gif' );

$files = array ();

if ( is_dir ( $directory ) )
{
	if ( $dh = opendir ( $directory ) )
	{
		while ( ( $file = readdir ( $dh ) ) !== FALSE )
		{
			if ( $file != '.' && $file != '..' )
			{	
				if ( is_array ( $allow ) && in_array ( get_extension ( $file ), $allow ) )
				{
					$files[] = $file;
				}
			}
		}
		closedir ( $dh );
	}
}

foreach ( $files as $file )
{
	echo $file . "<br>";	
}


?>