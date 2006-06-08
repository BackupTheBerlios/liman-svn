<?php
	require_once("include/tests/errormessage.php");
	
	class AutorTest
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
			$data = new stdClass();
			$data->Name = "Nur ein Mensch";
			$data->Nr = 127;
			
			$autor = new Autor( $data );
			
			if( $data->Nr != $autor->Nr )
				return new ErrorMessage( "Autor", "ctor", "Nummer", $data->Nr, $autor->Nr );
				
			if( $data->Name != $autor->Name )
				return new ErrorMessage( "Autor", "ctor", "Nummer", $data->Name, $autor->Name );
				
			return true;
		}
		
		function GetAll()
		{
			global $sqldb;
			
			$testAutoren = array();
			for( $i = 0; $i < 3; $i++ )
			{
				$autor = new stdObject();
				$autor->Nr = $i;
				$autor->Name = "Autor $i";
				$testAutoren[] = $autor;
			}
			
			$sqldb->ExpectQuery( '', $testAutoren );
			
			$resultAutoren = Autor::GetAll( 123 );
			
			$result = $sqldb->Verify();
			
			if( $result !== true )
			{
				$result->Unit = "Autor";
				$result->Test = "GetAll";
				return $result;
			}
			
			for( $i = 0; $i < 3; $i++ )
			{
				if( $testAutoren[$i]->Nr != $resultAutoren[$i]->Nr )
					return new ErrorMessage( "Autor", "GetAll", "Nummer von Autor $i falsch", $testAutoren[$i]->Nr, $resultAutoren[$i]->Nr );
				
				if( $testAutoren[$i]->Name != $resultAutoren[$i]->Name )
					return new ErrorMessage( "Autor", "GetAll", "Name von Autor $i falsch", $testAutoren[$i]->Name, $resultAutoren[$i]->Name );
			}
			
			return true;
		}
		
		function Split()
		{
			global $sqldb;
			
			$testAutorNamen = "Schon Vorhanden, Wird Hinzugefügt";
			
			$testAutoren = array();
			$testAutoren[] = new stdObject();
			$testAutoren[] = new stdObject();
			
			$testAutoren[0]->Nr = 1;
			$testAutoren[1]->Nr = 2;
			 
			$sqldb->ExpectQuery( 'SELECT.*Autor_Nr.*WHERE.*Autorname', $testAutoren[0] );
			$sqldb->ExpectQuery( 'SELECT.*Autor_Nr.*WHERE.*Autorname', false  );
			$sqldb->ExpectQuery( 'INSERT INTO.*', 1 );
			$sqldb->ExpectQuery( 'SELECT @@IDENTITY.*', $testAutoren[1] );
			
			$autoren = Autor::Split( $testAutorNamen );
			
			if( count($autoren) != count($testAutoren) )
				return new ErrorMessage( 'Autor', 'Split', 'Anzahl Autoren', count($testAutoren), count($autoren) );
				
			for( $i = 0; $i < count($autoren); $i++ )
			{
				if( $autoren[$i]->Nr != $testAutoren[$i]->Nr )
					return new ErrorMessage( 'Autor', 'Split', "Autor[$i]->Nr", $testAutoren[$i]->Nr, $autoren[$i]->Nr );
			}
			
			return true;
		}
	}
?>
