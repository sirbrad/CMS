<?php
include ( PATH . 'App/Third_party/phmagick.php' );

if ( !!$_POST )
	die ( 'ho' );
else
	die ( "wtf" );

error_reporting( E_ALL ^ ( E_NOTICE | E_WARNING ) );

$tmp_name = $_FILES['Filedata']['tmp_name'];

$name = $_FILES['Filedata']['name'];

$filesize = $_FILES['Filedata']['size'];

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
	$im = new imagick( $tmp_name );
	
	
	$im->setImageCompressionQuality(100); 
	
	
	$im->thumbnailImage( $_POST['width'], 0, FALSE );
	
	
	$im->writeImage( $dir . $newname );
	
	
	echo $newname;
	
}
else
{
	echo 'Invalid file'.";".'';
}


?>