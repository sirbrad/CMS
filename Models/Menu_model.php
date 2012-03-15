<?php

class Menu_model extends Super_model {
	
	private $_menu = array ();
	
	public function __Construct ()
	{
		parent::__Construct ();
		$this->_build();
	}
	
	private function _build ()
	{
		$tables = $this->db->list_tables ();
		
		$_db = 'cms_';
		
		$ignore = array ( $_db.'admin', 'framework_tests', $_db.'news' );
		
		$menu = array ();
		
		foreach ( $tables as $t )
		{
			if ( !in_array ( $t[0], $ignore ) && !!$t[0] )
			{
				$page = str_replace ( $_db, "", $t[0] );
				
				$this->_menu[] = array ( 'menu_item' => ucwords ( $page ),
									'link' => strtolower ( $page ) );
			}
		}
		// For some reason a blank element is inserted. Remove it.
		unset ( $this->_menu[0] );
		
		return $this;
	}
	
	public function get_menu ()
	{
		return $this->_menu;	
	}
	

}
?>