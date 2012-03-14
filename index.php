<?php
include ( 'App/Config.php' );

error_reporting( E_ALL );

$_router = Router::getInstance();

$_router->get_controller ();
?>