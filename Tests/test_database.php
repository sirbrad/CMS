<?php
require_once( dirname(__FILE__) . '/SimpleTest/autorun.php');

include ( '../App/Config.php');
include ( '../App/DB_Class.php' );
include ( '../App/DB_Driver.php' );


class Test_database extends UnitTestCase {
	
	private $db;
	
	public function __Construct () 
	{
		$this->db = DB_Class::getInstance ();
		return $this;
	}
	
	public function testConnection ()
	{
		$this->assertNotNull( $this->db );
	}
	
	public function testGetRow ()
	{
		$row = $this->db->set_query ( 'SELECT tests_id FROM framework_tests WHERE tests_id = 1' )->row();
		
		$this->assertTrue( $row );
		$this->assertNotNull( $row );
	}
	
	public function TestGetAssocArray ()
	{
		$query = $this->db->get ( 'SELECT tests_id FROM framework_tests' );
		
		$this->assertTrue( $query );
		$this->assertNotNull( $query );
	}
	
	/**
	 * Test for an empty query. Expect to get an exception back
	 */
	public function testEmptyQuery ()
	{
		$query = '';
		$query = $this->db->query ( $query );
		$this->assertFalse( $query );
	}
	
	public function testListTables ()
	{
		$tables = $this->db->list_tables ();
		
		// Shall only assert to true, as there may not be any tables.
		$this->assertTrue( $tables );	
	}
	
	public function testInsert ()
	{
		$return = $this->db->insert ( 'framework_tests', array ( 'tests_title' => 'testing', 'tests_content' => 'testing content' ) );	
		$this->assertTrue ( $return );
		$this->assertNotNull( $return );
	}
	
	public function testUpdate ()
	{
		$return = $this->db->where( 'tests_id', 1 )->update ( 'framework_tests', array ( 'tests_title' => 'testing', 'tests_content' => 'testing content' ) );
		$this->assertTrue ( $return );
	}
	
	public function testDescribe ()
	{
		$table = $this->db->describe_table ( 'framework_tests' );	
		$this->assertTrue ( $table );
		$this->assertNotNull ( $table );
		
		// Make a check that what is returned is an array
		$array_check = TRUE;
		
		if ( !is_array ( $table ) )
			$array_check = FALSE;
		else
			$array_check = TRUE;
			
		$this->assertTrue( $array_check );
			
	}
	
}
?>