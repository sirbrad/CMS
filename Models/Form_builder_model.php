<?php

class Form_builder_model extends Super_model {
	
	private $_text_inputs = array (),
			$_text_areas = array (),
			$_image_upload = array ();
			
	public function __Construct ( $table )
	{
		parent::__Construct();
		$this->_build ( $table );	
	}
	
	/**
	 * Build the arrays of form elements, depending on the type of column name 
	 */
	public function _build ( $table )
	{
		$table_cols = $this->db->describe_table ( PROJECT.'_'.$table );
		
		foreach ( $table_cols as $col )
		{
			$type = substr ( str_replace ( $table.'_', '', $col ), -strlen ( $col ), strlen ( $col ) );
			
			switch ( $type )
			{
				case 'title': case 'link': $info = array ( 'input_title' => ucwords ( $type ), 'input_name' => $col ); $this->_text_inputs[] = $info; break;
				case 'content': $info = array ( 'textarea_title' => ucwords ( $type ), 'textarea_name' => $col ); $this->_text_areas[] = $info; break;
				case 'imgname': $this->_image_upload[]['imgname'] = $col; break;	
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
	
}

?>