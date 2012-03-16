<?php
$_db = DB_Class::getInstance ();

$dir = $_SERVER['DOCUMENT_ROOT'] . '/' . DIRECTORY . '/Assets/Uploads/Images/';

// First Unlink the file from the server.
unlink ( $dir . $_POST['image'] );

// Set the imgname field from the new value thats been passed over
$_db->where ( $_POST['table'] . '_id', $_POST['id'] )->update ( PROJECT.'_'.$_POST['table'], array ( $_POST['table'] . '_imgname' => $_POST['newvalue'] ) );

// Return the image name, to be used to reference the div ID
echo $_POST['image'];

?>