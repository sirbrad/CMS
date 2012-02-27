<?php

class Arrays {
	
	/**
	 * Sets up an array of stylesheets to display
	 * @param string $string - the list of stylesheets, this needs to be comma seperated but.
	 * @param string $iterator - what the string is exploded by default comma.
	 * @return array
	 */
	public function stylesheets ( $string, $iterator = ',' )
	{
		$stylesheets = explode ( $iterator, str_replace ( ' ', '', trim ( $string ) ) );
		
		$styles = array ();
		
		foreach ( $stylesheets as $style )
		{
			$styles[]['stylesheet'] = $style;
		}
		
		return $styles;
	}
	
}

?>