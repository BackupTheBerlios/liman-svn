<?php
	require_once("include/tests/errormessage.php");
	
	class KommentarTest
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
			$testData = new stdObject();
			$testData->Nr = 1;
			$testData->Text = "Das ist ein Kommentar";
			$testData->Mitglieds_Nr = 2;
			$testData->Vorname = "Max";
			$testData->Nachname = "Mustermann";
			
			$kommentar = new Kommentar($testData);
			
			if( $testData->Nr != $kommentar->Nr )
				return new ErrorMessage( 'Kommentar', 'ctor', 'Kommentarnummer falsch', $testData->Nr, $kommentar->Nr );
				
			if( $testData->Text != $kommentar->Text )
				return new ErrorMessage( 'Kommentar', 'ctor', 'Kommenttext falsch', $testData->Text, $kommentar->Text );
				
			if( $testData->Mitglieds_Nr != $kommentar->Verfasser_Nr )
				return new ErrorMessage( 'Kommentar', 'ctor', 'Verfassernummer falsch', $testData->Mitglieds_Nr, $kommentar->Verfasser_Nr );
				
			if( $testData->Vorname." ".$testData->Nachname != $kommentar->Verfasser_Name )
				return new ErrorMessage( 'Kommentar', 'ctor', 'Verfassername falsch', $testData->Vorname." ".$testData->Nachname, $kommentar->Verfasser_Name );
				
			return true; 
		}
		
		function GetAll()
		{
			return new ErrorMessage( 'Kommentar', 'GetAll', 'Test nicht implementiert', null, null  );
		}
		
		function Insert()
		{
			return new ErrorMessage( 'Kommentar', 'Insert', 'Test nicht implementiert', null, null  );
		}
		
		function Update()
		{
			return new ErrorMessage( 'Kommentar', 'Update', 'Test nicht implementiert', null, null  );
		}
	}
?>
