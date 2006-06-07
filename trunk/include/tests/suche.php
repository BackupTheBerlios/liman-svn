<?php
	require_once("include/tests/errormessage.php");
	
	
	class SucheTest
	{
		var $suche;
		
		function Setup()
		{
			$suche = new Suche();
		}
		
		function TearDown()
		{
			global $sqldb;
			
			$sqldb->Verify();
		}
		
		function LetzteLiteratur()
		{
			global $sqldb;
			
			$testHits = array();
			$testHits[] = 1;
			$testHits[] = 2;
			$sqldb->ExpectQuery( '.*SELECT Literatur_Nr.*Bibliothek.*LIMIT.*', $testHits );
			
			// keine Autoren, Autor::GetAll soll in Autor Unit getestet werden
			for( $i = 0; $i < count($testHits); $i++ )
			{
				$sqldb->ExpectQuery( '.*SELECT.*Autor_Nr.*Autorname.*Literatur_Autor.*', false );
			}
			
			$this->suche->LetzteLiteratur();
			
			$result = $sqldb->Verify();
			
			if( $result !== true )
			{
				$result->Unit = "Suche";
				$result->Test = "LetzteLiteratur";
				return $result;
			}
			
			if( count($testHits) != count($this->suche->Treffer) )
				return new ErrorMessage( "Suche", "LetzteLiteratur", "Zahl der Treffer", count($testHits), count($this->suche->Treffer) );
			
			for( $i = 0; $i < count($testHits); $i++ )
			{
				if( $testHits[$i] != $this->suche->Treffer[$i] )
				{
					return new ErrorMessage( "Suche", "LetzteLiteratur", "Zahl der Treffer", $testHits[$i], $this->suche->Treffer[$i] );
				}
			}
			
			return true;
		}
		
		function VolltextSuche()
		{
			global $sqldb;
			
			$volltext = 'Prädikat';
			
			$testHits = array();
			$testHits[] = 1;
			$testHits[] = 2;
			
			$sqldb->ExpectQuery( '.*SELECT.*Bibliothek.*WHERE.*MATCH.*AGAINST.*', $testHits );
			
			for( $i = 0; $i < count($testHits); $i++ )
			{
				$sqldb->ExpectQuery( '.*SELECT.*Autor_Nr.*Autorname.*Literatur_Autor.*', false );
			}
			
			$suche->VolltextSuche( $volltext );
			
			$result = $sqldb->Verify();
			
			if( $result !== true )
			{
				$result->Unit = "Suche";
				$result->Test = "LetzteLiteratur";
				return $result;
			}
			
			if( count($testHits) != count($this->suche->Treffer) )
				return new ErrorMessage( "Suche", "LetzteLiteratur", "Zahl der Treffer", count($testHits), count($this->suche->Treffer) );
			
			for( $i = 0; $i < count($testHits); $i++ )
			{
				if( $testHits[$i] != $this->suche->Treffer[$i] )
				{
					return new ErrorMessage( "Suche", "LetzteLiteratur", "Zahl der Treffer", $testHits[$i], $this->suche->Treffer[$i] );
				}
			}
			
			return true;
		}
		
		function AutorTitelSuche()
		{
			global $sqldb;
			
			$titel = 'Ein Titel';
			$autor = 'Niemand';
			
			$testHits = array();
			$testHits[] = 1;
			$testHits[] = 2;
			
			$sqldb->ExpectQuery( '.*SELECT.*Bibliothek.*WHERE.*LIKE.*', $testHits );
			
			for( $i = 0; $i < count($testHits); $i++ )
			{
				$sqldb->ExpectQuery( '.*SELECT.*Autor_Nr.*Autorname.*Literatur_Autor.*', false );
			}
				
			$suche->AutorTitelSuche( $titel, $autor );
			
			$result = $sqldb->Verify();
			
			if( $result !== true )
			{
				$result->Unit = "Suche";
				$result->Test = "LetzteLiteratur";
				return $result;
			}
			
			if( count($testHits) != count($this->suche->Treffer) )
				return new ErrorMessage( "Suche", "LetzteLiteratur", "Zahl der Treffer", count($testHits), count($this->suche->Treffer) );
			
			for( $i = 0; $i < count($testHits); $i++ )
			{
				if( $testHits[$i] != $this->suche->Treffer[$i] )
				{
					return new ErrorMessage( "Suche", "LetzteLiteratur", "Zahl der Treffer", $testHits[$i], $this->suche->Treffer[$i] );
				}
			}
			
			return true;
		}
	}
?>
