<?php

class Router {

	private static $_instance = NULL;
	
	private $_uri = array (),
			$_controller;
	
	private function __construct () 
	{
		$this->_uri = preg_split ( '[\\/]', $_SERVER['REQUEST_URI'], -1, PREG_SPLIT_NO_EMPTY );
		$this->_set_route ();
	}
	
	public static function getInstance () 
	{
		if ( !self::$_instance instanceof self ) 
			self::$_instance = new self();
		
		 return self::$_instance;
	}
	
	private function _set_route ()
	{
		$this->_controller = CONTROLLER_SEG;
		return $this;
	}
	
	public function get_controller ()
	{
		$controller = 'Controllers/' . $this->_uri[ $this->_controller ] . '.php';
		
		if ( file_exists ( $controller ) )
			include ( $controller );
		else
			die ( 'Controller does not exist' );
	}
	
	public function get_controller_method ()
	{
		$method = ceil ( $this->_controller + 1 );	
		return $this->_uri[ $method ];
	}

	private function __clone () { }
	
} 
?>