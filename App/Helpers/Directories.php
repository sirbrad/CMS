<?php

class Directories {
	
	private $_allow,
			$_files = array ();
	
	public function get_extension ( $file )
	{
		if ( !!$file )
		{
			$path_parts = pathinfo ( $file );
			return $path_parts['extension'];
		}
		else
			return FALSE;	
	}
	
	public function set_allowed ( array $allow )
	{
		if ( !!$allow && is_array ( $allow ) )
		{
			$this->_allow = $allow;
			return $this;
		}
	}
	
	public function get_images ( $directory )
	{
		$this->build_array_files( $directory );
		return $this->_files;
	}
	
	public function build_array_files ( $directory )
	{
		if ( is_dir ( $directory ) )
		{
			if ( $dh = opendir ( $directory ) )
			{
				while ( ( $file = readdir ( $dh ) ) !== FALSE )
				{
					if ( $file != '.' && $file != '..' )
					{	
						if ( is_array ( $this->_allow ) )
						{
							if ( is_array ( $this->_allow ) && in_array ( $this->get_extension ( $file ), $this->_allow ) )
								$this->_files[] = $file;
						}
						else
						{
							$this->_files[] = $file;
						}
					}
				}
				closedir ( $dh );
			}
			return $this;
		}
		else
			return FALSE;
		
	}
	
}

?>