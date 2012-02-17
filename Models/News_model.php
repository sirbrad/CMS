<?php

class News_model extends Super_model {
	
	public function get_values ( $value = "" )
	{
		$query = $this->_db->get ( 'SELECT * FROM cms_news WHERE news_id = "' . $value . '"' );
		
		$tags = array ();
		
		foreach ( $query as $rows )
		{
			foreach ( $rows as $key => $value )
			{
				if ( $value == 1 )
					$tags[ $key ] = ' checked';
				else
					$tags[ $key ] = $value;
			}
		}
		return $tags;
	}

}
?>