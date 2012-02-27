<?php
/**
* ( This isn't really a super model in the respect of a hero,
	just a super class for all models :) )
*
* All Main models extend this that need access
* to the database.
*/
abstract class Super_model {
	
	protected $db;

	public function __Construct ()
	{
		$this->db = DB_Class::getInstance ();
	}
	
}

?>