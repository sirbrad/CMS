<?php
/**
* All Main models extend this that need access
* to the database.
*/
class Super_model {
	
	protected $db;

	public function __Construct ()
	{
		$this->db = DB_Class::getInstance ();
	}
	
}

?>