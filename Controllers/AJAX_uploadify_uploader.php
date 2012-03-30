<?php

$response = "";

foreach ( $_FILES['images'] as $key => $value )
{
	if ( $value == UPLOAD_ERR_OK ) 
	{  
		//$name = str_replace ( array ( " ", '"', "'", '&' ), array ( "-", "", "", "" ), $_FILES["images"]["name"] );
		
		$name = $_FILES["images"]["name"];
		
		$dir = $_SERVER['DOCUMENT_ROOT'] . '/' . DIRECTORY . '/Assets/Uploads/Images/';
		
		move_uploaded_file( $_FILES["images"]["tmp_name"], $dir . $_FILES['images']['name'] );
		
		$response = '/' . DIRECTORY . '/Assets/Uploads/Images/;'.$_FILES['images']['name'];
		die ( $response );
	} 
	else 
	{
		$response = $error;
	}
}

