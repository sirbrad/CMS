<?php

class Arrays {
	
	/**
	 * Builds a multi one dimensional array 
	 * 		exmample:  array ( array ( 'stylesheet' => 'style1' ), array ( 'stylesheet' => 'style2' ) );
	 *
	 * @param mixed $items - the array of css of values 
	 * @param string $key_title - the title of the key in the arrays
	 * @param optional iterator - if a string this is what is exploded
	 * @retun array
	 */
	public function mutli_one_dimension ( $items, $key_title, $iterator = ',' )
	{
		if ( !is_array ( $items ) )
			$items = explode ( $iterator, str_replace ( ' ', '', trim ( $items ) ) );
		
		$_array = array ();
		
		foreach ( $items as $value )
		{
			$_array[][ $key_title ] = $value;
		}
		
		return $_array;	
	}
	
	
}

?>