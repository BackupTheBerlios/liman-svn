<?php
	require_once("include/tests/errormessage.php");
	
	class AutorTest
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
			global $login, $sqldb;
			
			$sqldb->Verify();
			$login->Level = $this->login->Level;
			$login->Nr = $this->login->Nr;
			
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
				$autor = new stdClass();
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
			global $sqldb, $login;
			
			$login->Level = 0;	// Gast
			
			$testAutorNamen = "Schon Vorhanden, Wird Hinzugefügt";
			
			$autoren = Autor::Split( $testAutorNamen );
			
			$result = $sqldb->Verify();
			if( $result !== false )
			{
				$result->Unit = 'Autor';
				$result->Test = 'Split (Gast)';
				return $result;
			}
			
			$testAutoren = array();
			$testAutoren[] = new stdClass();
			$testAutoren[] = new stdClass();
			
			$testAutoren[0]->Nr = 1;
			$testAutoren[1]->Nr = 2;
			
			$login->Level = 1;	// Mitglied
			 
			$sqldb->ExpectQuery( 'SELECT.*Autor_Nr.*WHERE.*Autorname', $testAutoren[0] );
			$sqldb->ExpectQuery( 'SELECT.*Autor_Nr.*WHERE.*Autorname', false  );
			$sqldb->ExpectQuery( 'INSERT INTO.*', 1 );
			
			$autoren = Autor::Split( $testAutorNamen );

			$result = $sqldb->Verify();
			if( $result !== false )
			{
				$result->Unit = 'Autor';
				$result->Test = 'Split (Mitglied)';
				return $result;
			}
			
			if( count($autoren) != count($testAutoren) )
				return new ErrorMessage( 'Autor', 'Split (Mitglied)', 'Anzahl Autoren', count($testAutoren), count($autoren) );
			
			return true;
		}
	}
?>
