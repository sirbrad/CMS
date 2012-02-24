<?php

class Listing_model extends Super_model {
		
	private $_columns = array (),
			$_table,
			$_order_by,
			$_project = PROJECT;
	
	public function init ( $parameters = array () )
	{
		$this->setter( $parameters );
		
		if ( !!$_POST['delete'] )
			$alert = $this->delete_items ( $_POST['delete'] );
		
		return array ( $this->get_results (), $alert );
	}
	
	private function setter ( $to_set, $private = TRUE )
	{
		if ( is_array ( $to_set ) )
		{
			foreach ( $to_set as $key => $value )
				// Check to see if their private properties
				$private ? $this->{'_'.$key} = $value: $this->{$key} = $value;
		}
		else
		{
			return FALSE;	
		}
		
		return $this;
	}
	
	private function get_results ()
	{
		// Check to see if columns have been set, otherwise we just grab the description of the table given
		if ( sizeof ( $this->_columns ) == 0 )
		{
			// Now these are the columns to query and list
			$desc = $this->db->describe_table ( $this->_project . '_' .$this->_table );
			$this->_columns = $desc;
		}
		
		$columns = implode ( ', ', $this->_columns );
		
		if ( !!$this->_order_by )
			$order_by = 'ORDER BY ' . $this->_order_by;
		
		$query = $this->db->get ( 'SELECT ' . $columns . ' FROM ' . $this->_project . '_' .$this->_table . ' ' . $order_by );
		
		$result = array ();
		
		// Loop through the query
		foreach ( $query as $row )
		{
			$cols = array ();
			// Loop through the columns to get the column names to build the result array
			for ( $i = 0; $i < sizeof ( $this->_columns ); $i++ )
				$cols[ $this->_columns[ $i ] ] = $row[ $this->_columns[ $i ] ];
			
			$result[] = $cols;
		}
		
		return $result;
	}
	
	private function delete_items ( $items )
	{
		foreach ( $items as $id )
			$this->db->query ( 'DELETE FROM ' . $this->_project . '_' .$this->_table . ' WHERE ' . $this->_table . '_id = "' . $id . '"' );	
			
		return  '<div class="fbk error">
					<p>The item(s) you selected have now been deleted. They shall not be returning.</p>
				</div>';
	}

}
?>