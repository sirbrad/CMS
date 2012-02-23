<?php

class DB_Class {
	
	private $_conn,
			$_query,
			$_where = array ();
	
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
	
	public function get_where ()
	{
		return $this->_where;	
	}
	
	public function where( $col, $val = "" )
	{
		if( $col == '' )
		{
			return TRUE;
		}
		else
		{
			$where = $col;

			if ( !!$val )
			{
				$where = $col .' = "'. $this->escape ( $val ) .'"';
			}

			array_push ( $this->_where, $where );

			return $this;
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
	
	public function num_rows ()
	{
		if ( isset( $this->_query ) )
		{
			$num = $this->_conn->prepare( $this->_query );
			$num->execute();
			
			return $num->rowCount();
		}
		else
		{
			die ( 'A query must be set using query() to use num_rows()' );	
		}
	}
	
	
	/*
	*
	* Insert into database.
	* @param $table
	* @param array $data to insert
	*
	*/
	public function insert ( $table, $data = array() )
	{
		$columns = array();
		$values = array();
		
		if ( !!$table && $data )
		{
			foreach ( $data as $key => $value )
			{
				array_push( $columns , $key );
				array_push( $values , ':'. $key );
			}
			
			$stmt = $this->_conn->prepare( 'INSERT INTO ' . $table . ' ( ' . implode ( ', ', $columns ) . ' ) VALUES ( ' . implode ( ', ', $values  ) . ' )' );
			
			foreach ( $data as $key => $value )
			{
				$stmt->bindParam( ':' . $key , $this->escape( $value ) );	
			}
			
			$stmt->execute();
			
			// Check if any rows were inserted then return last insert ID
			if ( $stmt->rowCount() == 1 ) 
			{
				return $this->_conn->lastInsertId();
			}
			else 
			{
				$this->pdoError();
				
				return FALSE;
			}
		}
		else
		{
			trigger_error( "Table and Data must be set to insert into Database", E_USER_ERROR );
			return FALSE;	
		}
		
		
	}
	
	
	/*
	* Used for updating
	* Let me just say that I am very proud of this function
	* It was FRICKING fiddly doing it the PDO way,
	* and completely different to the normal sql way so there! :)
	*/
	public function update ( $table, $data = array() )
	{
		if ( !!$table && $data )
		{
			$update = array();
			$values = array();
			
			foreach ( $data as $key => $value )
			{
				// PDO takes ? to be replaced by a value upon execute
				array_push( $update , $key . ' = ? '  );
				// Set up the values to be replaced by said ? and escape for good measure.
				array_push( $values, $this->escape( $value ) );
			}
			
			if ( !!$this->_where )
			{
				$where = ' WHERE '  . implode( ' AND ', $this->_where );
			}
			
			
			$stmt = $this->_conn->prepare( 'UPDATE ' . $table . ' SET ' . implode ( ', ', $update ) . ' ' . $where . ' ' );
			
			$stmt->execute( $values );
			
			return TRUE;
		}
		else
		{
			trigger_error( "Table and Data must be set to update an entry within Database", E_USER_ERROR );
			return FALSE;
		}
	}
	
	private function __clone () { }


}

?>