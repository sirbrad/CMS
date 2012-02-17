<?php
/**
* All Main models extend this that need access
* to the database.
*/
class Super_model {
	
	protected $_db;

	public function __Construct ()
	{
		$this->_db = DB_Class::getInstance ();
	}
	
}

?>