<?php
/**
* A class for fetching and saving data
*
* @author Ashley Banks 2012
*/
class Data_model extends Super_model {
	
	private $_columns = array (),
			$_id,
			$_table,
			$_id_column,
			$_tags = array (),
			$_project = PROJECT;
			
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
		
		if ( !!$_POST['save'] )
		{
			if ( !!$_POST['hidden_id'] && $_POST['hidden_id'] != ' ' )
				$this->_id = $_POST['hidden_id'];
				
			$reponse_msg = $this->save ();
		}
			
		if ( !!$this->_id )
			$this->get_data ();
			
		return array ( $this->_tags, $this->_id );
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
				// Check to see if their private properties
				$private ? $this->{'_'.$key} = $value: $this->{$key} = $value;
		}
		else
		{
			return FALSE;	
		}
		
		return $this;
	}
	
	/**
	 * Gathers up the widgets so we can loop through and display in the view.
	 * @param string $type - the type of widget i.e Dropdowns / Downloads
	 * @param string $table - the table of the widget we are getting from - for example news
	 */
	public function get_widgets ( $type, $table )
	{
		$query = $this->db->get( 'SELECT * FROM ' . $this->_project . '_' . $type . '' );
		
		$saved_widgets = explode ( ',', $this->_tags[ $table.'_'.$type ] );
		
		$widgs = array ();
		
		if ( $this->db->num_rows () > 0 )
		{
			foreach ( $query as $row )
			{
				$checked = in_array ( $row[ $type.'_id'], $saved_widgets ) ? 'checked="checked"' : ' ';
				
				$widgs[] = array ( $type.'_title' => $row[ $type.'_title' ] ,
								   $type.'_id' => $row[ $type.'_id' ],
								   $type.'_checked' => $checked );
			}
		}
			
		return $widgs;
			
	}
		
	/**
	 * Gets the data and builds up the array of tags
	 */	
	private function get_data ()
	{
		// Build string of the columns to return
		$select = implode ( ', ', $this->_columns );
		
		$query = $this->db->get ( 'SELECT ' . $select . ' FROM ' . $this->_project.'_'.$this->_table . ' WHERE ' . $this->_id_column . ' = "' . $this->_id . '"' );
		
		if ( $this->db->num_rows () > 0 )
		{
			// Loop through the query results
			foreach ( $query as $rows )
			{
				// loop through the returned query result to get the column name and value
				// to assign a column name to the tags array
				foreach ( $rows as $key => $value )
					if ( $value == 1 && substr ( $key, -2, strlen ( $key ) ) == 'on' )
						$this->_tags[ $key ] = 'checked="checked"';
					else
						$this->_tags[ $key ] = $value != '' ? $value : ' ';
					/**
					 * The above checks for an int - that way we know whether to set it to checked ( for radios and checkboxes )
					 * ALSO:
					 * 		It's a bit of a hack, but so that we don't see the template tags if a value is empty we assign,
					 * 		a blank value to the value - so that the templater picks this up and removes it....arse over tit but
					 * 		it gets the damn thing working!!!!!
					 *
					 */
					
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
			if ( is_array ( $_POST[ $col ] ) )
				$fields[ $col ] = implode ( ",", $_POST[ $col ] );
			else
				// Checks if a column is urltitle to assign a friendly url
				$fields[ $col ] = substr ( $col, -8, strlen ( $col ) ) == 'urltitle' ? friendly_url ( $_POST[ $col ] ): $_POST[ $col ];
			
		}
		
		if ( !!$this->_id )
		{
			$this->db->where( $this->_id_column, $this->_id )->update( $this->_project.'_'.$this->_table, $fields );
			$msg = 'updated';
		}
		else
		{
			$nums = $this->db->insert( $this->_project.'_'.$this->_table, $fields );
			
			// Check that an insert has happened
			if ( $nums > 0 )
			{
				$msg = 'inserted';
				$this->_id = $nums;
			}
			else
				return FALSE;
		}
		
		//unset ( $fields );
		
		$this->_tags['alert'] = '<div class="fbk success">
									<p>Congratulations! The item has been ' . $msg . '.</p>
								</div>';
		
		
		return $this;
	}

}
?>