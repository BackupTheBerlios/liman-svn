<?php
	require_once("include/tests/errormessage.php");
	require_once("include/tests/sqldb_mock.php");
	require_once("include/kommentar.php");
	
	class KommentarTest
	{
		var $login;
		
		function Setup()
		{
			global $login;
			
			$this->login = new stdClass();
			$this->login->Level = $login->Level;
			$this->login->Nr = $login->Nr;
		}
		
		function TearDown()
		{
			global $sqldb, $login;
			
			$login->Level = $this->login->Level;
			$login->Nr = $this->login->Nr;
			
			$sqldb->Verify();
		}
		
		function CreateKommentarData( $nr, $text, $mitglieds_nr, $vorname, $nachname )
		{
			$data = new stdClass();
			$data->Nr = $nr;
			$data->Text = $text;
			$data->Mitglieds_Nr = $mitglieds_nr;
			$data->Vorname = $vorname;
			$data->Nachname = $nachname;
			
			return $data;
		}
		
		function ConstructorTest()
		{
			$testData = $this->CreateKommentarData( 1, "Das ist ein Kommentar", 2, "Max", "Mustermann" );
			
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
		
		function Delete()
		{
			global $sqldb, $login;
			
			$login->Level = 0;
			
			Kommentar::Delete( 0 );
			
			$dbResult = $sqldb->Verify();
			
			if( $dbResult !== true )
			{
				$dbResult->Unit = 'Kommentar';
				$dbResult->Test = 'Delete (Gast)';
				return $dbResult;
			}
			
			$login->Level = 1;
			
			$sqldb->ExpectQuery( 'DELETE FROM.*Kommentare.*WHERE.*Mitglieds_Nr.*', 1 );
			
			Kommentar::Delete( 0 );
			
			$dbResult = $sqldb->Verify();
			
			if( $dbResult !== true )
			{
				$dbResult->Unit = 'Kommentar';
				$dbResult->Test = 'Delete (Mitglied)';
				return $dbResult;
			}
			
			$login->Level = 2;
			
			$sqldb->ExpectQuery( 'DELETE FROM.*Kommentare.*WHERE.*', 1 );
			
			Kommentar::Delete( 0 );
			
			$dbResult = $sqldb->Verify();
			
			if( $dbResult !== true )
			{
				$dbResult->Unit = 'Kommentar';
				$dbResult->Test = 'Delete (Admin)';
				return $dbResult;
			}
			
			return true;
		}
		
		function GetAll()
		{
			global $sqldb;
			
			$testData = array();
			$testData[] = $this->CreateKommentarData( 1, "Das ist ein Kommentar", 1, "Max", "Mustermann" );
			$testData[] = $this->CreateKommentarData( 2, "Noch ein Kommentar", 2, "Fritz", "Fischer" );
			
			$sqldb->ExpectQuery( 'SELECT.*FROM.*Kommentare', $testData );
			$result = Kommentar::GetAll(1);
			
			$dbResult = $sqldb->Verify();
			if( $dbResult !== true )
			{
				$dbResult->Unit = 'Kommentar';
				$dbResult->Test = 'GetAll';
				return $dbResult;
			}

			if( count($testData) != count($result) )
				return new ErrorMessage( 'Kommentar', 'GetAll', 'Anzahl Kommentare', count($testData), count($result) );
			
			return true;
		}
		
		function Insert()
		{
			global $login, $sqldb;
			
			$login->Level = 0;
			
			Kommentar::Insert( "Ein Kommentar", 1, 1 );
			$dbResult = $sqldb->Verify();
			
			if( $dbResult !== true )
			{
				$dbResult->Unit = 'Kommentar';
				$dbResult->Test = 'Insert (Gast)';
				return $dbResult;
			}
			
			//----------------------------------------------------------------
			
			$login->Level = 1;
			$login->Nr = 1;
			
			Kommentar::Insert( "Noch ein Kommentar", 2, 1 );
			$dbResult = $sqldb->Verify();
			
			if( $dbResult !== true )
			{
				$dbResult->Unit = 'Kommentar';
				$dbResult->Test = 'Insert (anderes Mitglied)';
				return $dbResult;
			}
			
			//----------------------------------------------------------------
			$sqldb->ExpectQuery( "SELECT Literatur_Nr FROM .*Bibliothek".
			                     " WHERE Literatur_Nr", false );
			
			Kommentar::Insert( "Noch ein Kommentar", 1, 1 );
			
			$dbResult = $sqldb->Verify();
			
			if( $dbResult !== true )
			{
				$dbResult->Unit = 'Kommentar';
				$dbResult->Test = 'Insert (ohne Literatur)';
				return $dbResult;
			}
			
			//----------------------------------------------------------------
			$sqldb->ExpectQuery( "SELECT Literatur_Nr FROM .*Bibliothek".
			                     " WHERE Literatur_Nr", new stdClass() );	// Ergebniss darf nicht leer sein
			$sqldb->ExpectQuery( "SELECT Kommentar_Nr FROM .*Kommentare WHERE Literatur_Nr.* AND Mitglieds_Nr.*", false );
			$sqldb->ExpectQuery( "INSERT INTO .*Kommentare", 1 );
			
			Kommentar::Insert( "Noch ein Kommentar", 1, 1 );
			$dbResult = $sqldb->Verify();
			
			if( $dbResult !== true )
			{
				$dbResult->Unit = 'Kommentar';
				$dbResult->Test = 'Insert (Mitglied)';
				return $dbResult;
			}
			
			//----------------------------------------------------------------
			$login->Level = 2;
			
			$sqldb->ExpectQuery( "SELECT Literatur_Nr FROM .*Bibliothek".
			                     " WHERE Literatur_Nr", new stdClass() );
			$queryResult = new stdClass();
			$queryResult->Kommentar_Nr = 1;
			$sqldb->ExpectQuery( "SELECT Kommentar_Nr FROM .*Kommentare".
			                     " WHERE Literatur_Nr.* AND Mitglieds_Nr.*", $queryResult );
			$sqldb->ExpectQuery( "UPDATE .*Kommentare", 1 );
			
			Kommentar::Insert( "Noch ein Kommentar", 2, 1 );
			$dbResult = $sqldb->Verify();
			
			if( $dbResult !== true )
			{
				$dbResult->Unit = 'Kommentar';
				$dbResult->Test = 'Insert (Admin)';
				return $dbResult;
			}
			
			return true;
		}
		
		function Update()
		{
			global $login, $sqldb;
			
			$login->Level = 1;
			
			$sqldb->ExpectQuery( 'DELETE FROM.*Kommentare', 1 );
			Kommentar::Update( 1, "" );		// Wenn Text leer ist, soll Kommentar gel�scht werden
			$dbResult = $sqldb->Verify();
			if( $dbResult !== true )
			{
				$dbResult->Unit = 'Kommentar';
				$dbResult->Test = 'Update (leer)';
				return $dbResult; 
			}
			
			$sqldb->ExpectQuery( 'UPDATE.*Kommentare.*WHERE.*Mitglieds_Nr', 1 );
			Kommentar::Update( 1, "Neuer Text" );
			$dbResult = $sqldb->Verify();
			if( $dbResult !== true )
			{
				$dbResult->Unit = 'Kommentar';
				$dbResult->Test = 'Update (Mitglied)';
				return $dbResult; 
			}
			
			$login->Level = 2;
			
			$sqldb->ExpectQuery( 'UPDATE.*Kommentare.*WHERE', 1 );
			Kommentar::Update( 1, "Neuer Text" );
			$dbResult = $sqldb->Verify();
			if( $dbResult !== true )
			{
				$dbResult->Unit = 'Kommentar';
				$dbResult->Test = 'Update (Admin)';
				return $dbResult; 
			}
			
			return true;
		}
	}
?>
