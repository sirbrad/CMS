<?php

$_db = DB_Class::getInstance ();

$response = "";

// http://net.tutsplus.com/tutorials/javascript-ajax/uploading-files-with-ajax/
foreach ( $_FILES["files"]["error"] as $key => $error )
{ 
	if ( $error == UPLOAD_ERR_OK ) 
	{  
		$name = $_FILES["files"]["name"][$key];
		
		$dir = $_SERVER['DOCUMENT_ROOT'] . '/' . DIRECTORY . '/Assets/Uploads/Documents/';
		
		$filename = str_replace ( ' ', '_', $_FILES['files']['name'][$key] );
		$filetitle = $_FILES['files']['name'][$key];
		
		$extension  = strtolower ( pathinfo ( $filename, PATHINFO_EXTENSION ) );
		
		for ( $filecounter = 1; file_exists( $dir . $filename ); $filecounter++ )
		{
			$filename = $filename. '-' . $filecounter . "." . $extension ;
		}
		
		move_uploaded_file ( $_FILES["files"]["tmp_name"][$key], $dir . $filetitle );
		
		$num = $_db->insert ( PROJECT.'_documents', array ( 'documents_title' => $filetitle, 'documents_name' => $filename ) );
		
		unset ( $_FILES['files']['name'][$key] );
		unset ( $_FILES['files']['tmp_name'][$key] );
		
		$response = $filetitle.';'.$filename;
		//$reponse = $filetitle . ' ' . $filename;
		
	} 
	else 
	{
		$response = $error;
	}
}

echo $response;

?>