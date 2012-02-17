<?php
// Change this to the table definition of the project.
$_db_site = 'cms';

$_db = DB_Class::getInstance (); 

$username = $_db->escape ( $_POST['username'] );
$password = $_db->db->escape ( $_POST['password'] );

$_db->set_query ( 'SELECT * FROM ' . $_db_site . '_admin WHERE admin_username = "' . $username . '" AND admin_password = "' . sha1( $password ) . '" LIMIT 1' );

if ( (int) $_db->num_rows() > 0 )
{
	if ( !!$_POST['remember'] )
	{
		setcookie( 'cp_admin_username', mysql_real_escape_string( $_POST['username'] ), time()+60*60*24*30 );
		setcookie( 'cp_admin_password',  mysql_real_escape_string( $_POST['password'] ), time()+60*60*24*30 );
	}	
	
	$_SESSION['userID'] = $username;
	
	// Example to set clean up
	$image_cleanup = array( $_db_site . '_table' => 'table_imgname' );
	//$this->cleanup->clean_up( $_SERVER['DOCUMENT_ROOT'].'/' . DIRECTORY . 'Assets/Uploads/Images', $image_cleanup );
	
	echo 'ok';
}
else
{
	echo 'not_ok';	
}


?>