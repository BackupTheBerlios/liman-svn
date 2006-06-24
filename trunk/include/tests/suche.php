<?php
	require_once("include/tests/errormessage.php");
	require_once("include/tests/sqldb_mock.php");
	require_once("include/suche.php");
	
	class SucheTest
	{
		var $suche;
		var $testHits;
		
		function CreateResult( $nr, $titel, $verlag, $isbn )
		{
			$result = new stdClass();
			$result->Nr = $nr;
			$result->Titel = $titel;
			$result->Verlag = $verlag;
			$result->ISBN = $isbn;
			return $result;
		}
		
		function CompareResults( $realHits )
		{
			if( count($realHits) != count($this->testHits) )
				return new ErrorMessage( 'Suche', null, 'Anzahl Treffer', count($this->testHits), count($realHits) );
			
			for( $i = 0; $i < count($this->testHits); $i++ )
			{
				
			}
		}
		
		function Setup()
		{
			$this->testHits = array();
			$this->testHits[] = SucheTest::CreateResult( 1, 'Nachtvogel', 'Blanvalet', '3-442-24258-4' );
			$this->testHits[] = SucheTest::CreateResult( 2, 'Dämonensommer', 'Blanvalet', '3-422-24257-6' );
		}
		
		function TearDown()
		{
			global $sqldb;
			
			$sqldb->Verify();
		}
		
		function LetzteLiteratur()
		{
			global $sqldb;
			
			$sqldb->ExpectQuery( '.*SELECT Literatur_Nr.*Bibliothek.*LIMIT.*', $this->testHits );
			
			// keine Autoren, Autor::GetAll soll in Autor Unit getestet werden
			for( $i = 0; $i < count($this->testHits); $i++ )
			{
				$sqldb->ExpectQuery( '.*SELECT.*Autor_Nr.*Autorname.*Literatur_Autor.*', false );
			}
			
			$this->suche = new Suche();
			
			$result = $sqldb->Verify();
			
			if( $result !== true )
			{
				$result->Unit = "Suche";
				$result->Test = "LetzteLiteratur";
				return $result;
			}
			
			if( count($this->testHits) != count($this->suche->Treffer) )
				return new ErrorMessage( "Suche", "LetzteLiteratur", "Zahl der Treffer", count($this->testHits), count($this->suche->Treffer) );
			
			return true;
		}
		
		function VolltextSuche()
		{
			global $sqldb;
			
			$volltext = 'Prädikat';
			
			$sqldb->ExpectQuery( '.*SELECT.*Bibliothek.*WHERE.*MATCH.*AGAINST.*', $this->testHits );
			
			for( $i = 0; $i < count($this->testHits); $i++ )
			{
				$sqldb->ExpectQuery( '.*SELECT.*Autor_Nr.*Autorname.*Literatur_Autor.*', false );
			}
			
			$this->suche = new Suche($volltext);
			
			$result = $sqldb->Verify();
			
			if( $result !== true )
			{
				$result->Unit = "Suche";
				$result->Test = "LetzteLiteratur";
				return $result;
			}
			
			if( count($this->testHits) != count($this->suche->Treffer) )
				return new ErrorMessage( "Suche", "LetzteLiteratur", "Zahl der Treffer", count($this->testHits), count($this->suche->Treffer) );
			
			
			return true;
		}
		
		function AutorTitelSuche()
		{
			global $sqldb;
			
			$titel = 'Ein Titel';
			$autor = 'Niemand';
			
			$sqldb->ExpectQuery( '.*SELECT.*Bibliothek.*WHERE.*LIKE.*', $this->testHits );
			
			for( $i = 0; $i < count($this->testHits); $i++ )
			{
				$sqldb->ExpectQuery( '.*SELECT.*Autor_Nr.*Autorname.*Literatur_Autor.*', false );
			}
				
			$this->suche = new Suche($titel, $autor);
			
			$result = $sqldb->Verify();
			
			if( $result !== true )
			{
				$result->Unit = "Suche";
				$result->Test = "LetzteLiteratur";
				return $result;
			}
			
			if( count($this->testHits) != count($this->suche->Treffer) )
				return new ErrorMessage( "Suche", "LetzteLiteratur", "Zahl der Treffer", count($this->testHits), count($this->suche->Treffer) );
			
			return true;
		}
	}
?>
