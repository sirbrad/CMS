<?php

$response = "";

// http://net.tutsplus.com/tutorials/javascript-ajax/uploading-files-with-ajax/
foreach ($_FILES["images"]["error"] as $key => $error)
{ 
	if ($error == UPLOAD_ERR_OK) 
	{  
		$name = $_FILES["images"]["name"][$key];
		
		$dir = $_SERVER['DOCUMENT_ROOT'] . '/' . DIRECTORY . '/Assets/Uploads/Images/';
		
		move_uploaded_file( $_FILES["images"]["tmp_name"][$key], $dir . $_FILES['images']['name'][$key] );
		
		$response = '/' . DIRECTORY . '/Assets/Uploads/Images/;'.$_FILES['images']['name'][$key];
	} 
	else 
	{
		$response = $error;
	}
}

echo $response;
/*	
include ( PATH . 'App/Third_party/phmagick.php' );

error_reporting( E_ALL ^ ( E_NOTICE | E_WARNING ) );

$tmp_name = $_FILES['images']['tmp_name'][0];

$name = $_FILES['images']['name'][0];

$filesize = $_FILES['images']['size'][0];

$extension  = strtolower( pathinfo( $name, PATHINFO_EXTENSION ) );

$basename = basename( str_replace( ' ', '_', $name ), '.' . $extension );

$newname = $basename . "." . $extension ;

$dir = $_SERVER['DOCUMENT_ROOT'] . '/Assets/Uploads/Images/';


for( $filecounter = 1; file_exists( $dir . $newname ); $filecounter++ )
{
	$newname = $basename. '-' . $filecounter . "." . $extension ;
}
if( !empty( $tmp_name ) )
{
	$im = new Imagick( $tmp_name );
	
	
	$im->setImageCompressionQuality(100); 
	
	
	$im->thumbnailImage( $_POST['width'], 0, FALSE );
	
	
	$im->writeImage( $dir . $newname );
	
	
	echo $newname;
	
}
else
{
	echo 'Invalid file'.";".'';
}

*/


?>