<?php

class News_model extends Super_model {
	
	public function get_values ( $value = "" )
	{
		if ( !!$value )
		{
			$query = $this->_db->get ( 'SELECT * FROM cms_news WHERE news_id = "' . $value . '"' );
			
			$tags = array ();
			
			if ( $this->_db->num_rows() > 0 )
			{
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
	}
	
	public function save_news ( $cols, $id )
	{
		if ( !!$_POST )
		{
			$_save_cols = array ();
			
			foreach ( $cols as $col )
			{
				$_save_cols[ $col ] = $_POST[ $col ];		
			}
			
			if ( !!$id )
			{
				$this->_db->where( 'news_id', $id )->update( 'cms_news', $_save_cols );
				
				return '<div class="fbk success"><p>Item has been updated.</p></div>';
			}
			else
			{
				$num = $this->_db->insert ( 'cms_news', $_save_cols );
				
				if ( $num > 0 )
					return '<div class="fbk success"><p>Item has been inserted.</p></div>';
				else 
					return FALSE;
			}
		}
		
	}

}
?>