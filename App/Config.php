<?php

/** Database Details **/
define ( 'DB_HOST', 'localhost' );
define ( 'DB_NAME', 'cms_2012' );
define ( 'DB_USER', 'root' );
define ( 'DB_PASSWORD', 'root' );



/** Site Configs **/

// The segment of the Controller in the URI
define ( 'CONTROLLER_SEG', 2 );

// The working directory, if none have blank
define ( 'DIRECTORY', 'GitHub/CMS' ); 

// The brand name of the site
define ( 'SITE_NAME', 'Brad/Ash CMS' );

define ( 'PROJECT', 'cms' );


/** Auto loading of classes **/

function __autoload ( $class_name ) 
{
    include 'App/' . $class_name . '.php';
	include 'App/Helpers/' . $class_name . '.php';
	include 'App/Libraries/' . $class_name . '.php';
	include 'Models/' . $class_name . '.php';
}

?>