<?php
require_once( dirname(__FILE__) . '/SimpleTest/autorun.php');

include ( '../App/Config.php');

class Test_autoloading extends UnitTestCase {
	
	public function testAutoLoad ()
	{
		// Without including the class we should be able to 
		// autoload the class
		$dir = new Directories;
		
		// Assert to true if we got the class
		$this->assertTrue ( $dir );
	}
	
}

?>