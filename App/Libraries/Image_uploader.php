<?php
include ( $_SERVER['DOCUMENT_ROOT'] . '/GitHub/CMS/App/Third_party/phmagick.php' );

class Image_uploader {
	
	public function upload () 
	{
		error_reporting( E_ALL ^ ( E_NOTICE | E_WARNING ) );
		
		$tmp_name = $_FILES['Filedata']['tmp_name'];
		
		$name = $_FILES['Filedata']['name'];
		
		$filesize = $_FILES['Filedata']['size'];
		
		$extension  = strtolower( pathinfo( $name, PATHINFO_EXTENSION ) );
		
		$basename = basename ( str_replace( ' ', '_', $name ), '.' . $extension );
		
		$newname = $basename . "." . $extension ;
		
		$dir = $_SERVER['DOCUMENT_ROOT'] . '/'.DIRECTORY . '/Assets/Uploads/Images/';
		
		for ( $filecounter = 1; file_exists( $dir . $newname ); $filecounter++ )
		{
			$newname = $basename. '-' . $filecounter . "." . $extension ;
		}
		
		if ( !empty( $tmp_name ) )
		{
			
			$im = new imagick( $tmp_name );
			
			$im->setDestination( $dir . $newname )
			   ->setImageQuality( 100 )
			   ->resize( 800 );
			
			die ( '<img src="' . $dir . $newname . '">' );
			
			return $newname;
			
		}
		else
		{
			return FALSE;
		}
	}
}


?>