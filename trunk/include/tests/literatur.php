<?php
	require_once("include/tests/errormessage.php");
	
	class LiteraturTest
	{
		function Setup()
		{
		}
		
		function TearDown()
		{
			global $sqldb;
			
			$sqldb->Verify();
		}
		
		function ConstructorTest()
		{
			return new ErrorMessage( 'Literatur', 'ctor', 'Test nicht implementiert', null, null );
		}
		
		function Insert()
		{
			return new ErrorMessage( 'Literatur', 'Insert', 'Test nicht implementiert', null, null );
		}
		
		function Update()
		{
			return new ErrorMessage( 'Literatur', 'Update', 'Test nicht implementiert', null, null );
		}
		
		function InsertBibtex()
		{
			return new ErrorMessage( 'Literatur', 'InsertBibtex', 'Test nicht implementiert', null, null );
		}
		
		function ToBibtex()
		{
			return new ErrorMessage( 'Literatur', 'ToBibtex', 'Test nicht implementiert', null, null );
		}
	}
?>
