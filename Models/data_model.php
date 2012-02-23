<?php

class Data_model extends Super_model {
	
	private $_columns = array (),
			$_id,
			$_table,
			$_id_column,
			$_tags = array ();
			
	/**
	 * Initialises the class
	 * @param array $attributes - the class properties to be set:
	 * 		table - the name
	 * 		columns - the columns to save/query
	 * 		id_column - the column to query for the where clause
	 * 		id - the value of the id column
	 */
	public function init ( $attributes = array () )
	{
		$this->setter( $attributes );
		
		if ( !!$_POST )
			$reponse_msg = $this->save ();	
			
		if ( !!$this->_id )
			$this->get_data ();
			
		return array ( $reponse_msg, $this->_tags );
	}
	
	/**
	 * Quickly sets class properties
	 * @param array $to_set - properties to set
	 * @param boolean $private - whether private/protected or public property
	 * @access public - just incase you need/want to set a property outside the class
	 */
	public function setter ( $to_set, $private = TRUE )
	{
		if ( is_array ( $to_set ) )
		{
			foreach ( $to_set as $key => $value )
			{
				if ( $private )
				{
					$set = '_'.$key; 
					$this->{$set} = $value;
				}
				else
					$this->{$key} = $value;
			}
		}
		else
		{
			return FALSE;	
		}
		
		return $this;
	}
		
	/**
	 * Gets the data and builds up the array of tags
	 */	
	private function get_data ()
	{
		// Build string of the columns to return
		$select = implode ( ', ', $this->_columns );
		
		$query = $this->db->get ( 'SELECT ' . $select . ' FROM ' . $this->_table . ' WHERE ' . $this->_id_column . ' = "' . $this->_id . '"' );
		
		if ( $this->db->num_rows () > 0 )
		{
			// Loop through the query results
			foreach ( $query as $rows )
			{
				// loop through the returned query result to get the column name and value
				// to assign a column name to the tags array
				foreach ( $rows as $key => $value )
				{
					if ( $value == 1 )
						$this->_tags[ $key ] = ' checked';
					else
						$this->_tags[ $key ] = $value;
				}
			}
			
			return $this;
		}
	}
	
	/**
	 * Saves the data, determined UPDATE or INSERT by a set identifier property
	 * @return string for the alert message
	 */
	private function save ()
	{
		$fields = array ();
		
		foreach ( $this->_columns as $col )
		{
			// Checks if a column is urltitle to assign a friendly url
			if ( substr ( $col, -8, strlen ( $col ) == 'urltitle' ) )
				$fields[ $col ] = friendly_url ( $_POST[ $col ] );
			else
				$fields[ $col ] = $_POST[ $col ];
		}
			
		if ( !!$this->_identifier )
		{
			$this->db->where( $this->_id_column, $this->_id )->update( $this->_table, $fields );
			$msg = 'updated';
		}
		else
		{
			$nums = $this->db->insert( $this->_table, $fields );
			
			// Check that an insert has happened
			if ( $nums > 0 )
				$msg = 'inserted';
			else
				return FALSE;
		}
		
		unset ( $fields );
		
		return '<div class="fbk success"><p>Item has been ' . $msg . '.</p></div>';
	}

}
?>