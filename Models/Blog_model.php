<?php

class Blog_model extends Super_model {
	
	public function get_categories ( $selected )
	{
		$query = $this->db->get ( 'SELECT * FROM cms_blog_categories ORDER BY category_title ASC' );
		
		$res = array ();
		
		foreach ( $query as $row )
		{
			$res[] = array ( 'title' => $row['category_title'],
							 'value' => $row['category_id'] );
		}
		
		return $res;
	}
	
}