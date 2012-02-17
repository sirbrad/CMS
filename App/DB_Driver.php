<?php

class DB_Driver {

	private static $_instance = NULL;
	
	private function __construct () 
	{
		// Empty at the mo
	}
	
	public static function getInstance () 
	{
		if ( !self::$_instance )
		{
			try 
			{
				$hostname = DB_HOST;
				$database = DB_NAME;
				
				self::$_instance = new PDO ( "mysql:host=$hostname;dbname=$database", DB_USER, DB_PASSWORD );
				self::$_instance->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			}
			catch ( PDOException $e )
			{
				echo $e->getMessage ();
			}
				
		}
		return self::$_instance;
	}
	
	
	private function __clone () { }
	
} 
?>