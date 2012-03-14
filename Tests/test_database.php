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
	
}
?>