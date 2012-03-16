<?php
$_db = DB_Class::getInstance ();

$dir = $_SERVER['DOCUMENT_ROOT'] . '/' . DIRECTORY . '/Assets/Uploads/Images/';

unlink ( $dir . $_POST['image'] );

$_db->where ( $_POST['table'] . '_id', $_POST['id'] )->update ( PROJECT.'_'.$_POST['table'], array ( $_POST['table'] . '_imgname' => $_POST['newvalue'] ) );

echo $_POST['image'];

?>