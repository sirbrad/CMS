<?php
require_once( dirname(__FILE__) . '/SimpleTest/autorun.php');

include ( '../App/Config.php');

class Test_dir_helper extends UnitTestCase {
	
	private $dir;
	
	/**
	 * Test we can initiate the class
	 */
	public function testInit ()
	{
		$dir = new Directories;
	
		$this->assertTrue ( $dir );
	}
	
	/**
	 * Now we know the class can be initiated we load it into a property
	 */
	public function __Construct ()
	{
		$this->dir = new Directories;	
	}
	
	public function testGetExtension ()
	{
		$ext = $this->dir->get_extension ( 'file.php' );
		
		$this->assertTrue ( $ext );
		$this->assertNotNull( $ext );
		
		// As I know the extension provided - make sure we are getting the same.
		$this->assertEqual ( $ext, 'php' );	
	}
	
	/**
	 * Had to put following tests in this order:
	 * As I'm not testing the allow on the build it will fail the test
	 * so the allow array is set after this test.
	 */
	public function testBuildArray ()
	{ 
		$dir = dirname(__FILE__);
		
		$return = $this->dir->build_array_files ( $dir );	
		$this->assertTrue ( $return );
		$this->assertNotNull( $return );
	}
	
	public function testAllow ()
	{
		$return = $this->dir->set_allowed ( array ( 1, 2, 3 ) );
		$this->assertTrue ( $return );
	}
	
	
	
}

?>