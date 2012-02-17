<?php

/** Database Details **/
define ( 'DB_HOST', 'localhost' );
define ( 'DB_NAME', 'singleton' );
define ( 'DB_USER', 'root' );
define ( 'DB_PASSWORD', 'root' );



/** Site Configs **/

// The segment of the Controller in the URI
define ( 'CONTROLLER_SEG', 1 );

// The working directory, if none have blank
define ( 'DIRECTORY', 'Singleton_Framework' ); 



/** Auto loading of classes **/

function __autoload ( $class_name ) {
    include 'App/' . $class_name . '.php';
}

?>