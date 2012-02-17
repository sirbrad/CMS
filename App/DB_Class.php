<?php

class DB_Class {
	
	private $_conn,
			$_query;
	
	private static $_instance = NULL;
	
	private function __Construct ()
	{
		$this->_conn = DB_Driver::getInstance();	
	}
	
	public static function getInstance ()
	{
		if ( !self::$_instance instanceof self ) 
		{
			self::$_instance = new self();
		}
		
		 return self::$_instance;
	}
	
	public function escape ( $string )
	{
		if ( !!$string )
		{
			$string = str_replace( "\r\n", "", $string );
			$string = mysql_escape_string( $string );
			$string = stripslashes( $string );
			return $string;
		}
		else
		{
			return FALSE;	
		}
	}
	
	public function set_query ( $query )
	{
		if ( !!$query )
		{
			$this->_query = $query;
			return $this;	
		}
		else
		{
			return FALSE;
		}	
	}
	
	public function row ()
	{
		if ( !$this->_query )
		{
			die ( "Must set a query before using method row()" );	
			return FALSE;
		}
		else
		{
			$stmt = $this->_conn->prepare( $this->_query );

			$stmt->execute();

			$result = $stmt->fetch( PDO::FETCH_OBJ );

			return $result;
		}

	}
	
	public function get ( $query = "" )
	{
		if ( !isset( $query ) && !isset( $this->_query ) )
		{
			return FALSE;	
		}
		else
		{
			if ( !!$query )
				$this->_query = $query;
				
			$stmt = $this->_conn->prepare( $this->_query );
			
			$stmt->execute();
			
			return $stmt->fetchAll();
		}
		
	}
	
	private function __clone () { }


}

?>