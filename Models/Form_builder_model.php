<?php

class Form_builder_model extends Super_model {
	
	private $_text_inputs = array (),
			$_text_areas = array (),
			$_image_upload = array (),
			$_dropdowns = FALSE,
			$_downloads = FALSE;
			
	public function __Construct ( $table = "" )
	{
		parent::__Construct();
		if ( !!$table )
			$this->_build ( $table );	
	}
	
	/**
	 * Returns a given tables columns - except for the primary key column
	 */
	public function get_table_cols ( $table )
	{
		
		$table_cols = $this->db->describe_table ( PROJECT.'_'.$table );
		
		// Ensure we do not include the primary key in the array.	
		for ( $i = 0; $i < sizeof ( $table_cols ); $i++ )
			if ( substr ( $table_cols[ $i ], -2, strlen ( $table_cols[ $i ] ) ) == 'id' ) 
				unset( $table_cols[ $i ] ); 
			if ( substr ( $table_cols[ $i ], -4, strlen ( $table_cols[ $i ] ) ) == 'date' ) 
				unset( $table_cols[ $i ] );
		
		return $table_cols;
	}
	
	/**
	 * Build the arrays of form elements, depending on the type of column name 
	 */
	private function _build ( $table )
	{
		$table_cols = $this->get_table_cols ( $table );
		
		foreach ( $table_cols as $col )
		{
			$type = substr ( str_replace ( $table.'_', '', $col ), -strlen ( $col ), strlen ( $col ) );
			
			switch ( $type )
			{
				case 'title': case 'link': $info = array ( 'input_title' => ucwords ( $type ), 'input_name' => $col ); $this->_text_inputs[] = $info; break;
				case 'content': $info = array ( 'textarea_title' => ucwords ( $type ), 'textarea_name' => $col ); $this->_text_areas[] = $info; break;
				case 'imgname': $this->_image_upload[]['imgname'] = $col; break;	
				case 'dropdowns' : $this->_dropdowns = TRUE;
				case 'downloads' : $this->_downloads = TRUE;
				//default: $text_inputs[] = $col; break;
			}
		}	
		
		return $this;
	}
	
	/**
	 * Getter method for the textinputs
	 */ 
	public function get_textinputs ()
	{
		return $this->_text_inputs;
	}
	
	/**
	 * Getter method for the text areas
	 */ 
	public function get_textareas ()
	{
		return $this->_text_areas;	
	}
	
	/**
	 * Getter method for the image uploaders
	 */ 
	public function get_imageuploads ()
	{
		return $this->_image_upload;	
	}
	
	public function get_dropdowns ()
	{
		return $this->_dropdowns;	
	}
	
	public function get_downloads ()
	{
		return $this->_downloads;	
	}
	
}

?>