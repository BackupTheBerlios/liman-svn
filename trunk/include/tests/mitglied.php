<?php
	require_once("include/tests/errormessage.php");
	
	class MitgliedTest
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
			global $sqldb;
			
			$testData = new stdObject();
			$testData->Nr = 1;
			$testData->Login = "Maximator";
			$testData->Passwort = Mitglied::PasswordHash("passwort");
			$testData->Vorname = "Max";
			$testData->Nachname = "Mustermann";
			$testData->Email != "max.mustermann@gmx.de";
			$testData->Rechte = "Benutzer";
			
			$sqldb->ExpectQuery("SELECT.*FROM.*Mitglieder.*WHERE.*Mitglieds_Nr.*LIMIT 1", $testData );
			
			$mitglied = new Mitglied(1);
			
			$result = $sqldb->Verify();
			if( $result !== true )
			{
				$result->Unit = 'Mitglied';
				$result->Test = 'ctor';
				return $result;
			}
			
			if( $mitglied->Nr != $testData->Mitglieds_Nr )
				return new ErrorMessage( 'Mitglied', 'ctor', 'Mitgliedsnummer falsch', $testData->Mitglieds_Nr, $mitglied->Mitglieds_Nr );
				
			if( $mitglied->Login != $testData->Login )
				return new ErrorMessage( 'Mitglied', 'ctor', 'Login falsch', $testData->Login, $mitglied->Login );
			
			if( $mitglied->Passwort != $testData->Passwort )
				return new ErrorMessage( 'Mitglied', 'ctor', 'Passwort falsch', $testData->Passwort, $mitglied->Passwort );
				
			if( $mitglied->Vorname != $testData->Vorname )
				return new ErrorMessage( 'Mitglied', 'ctor', 'Vorname falsch', $testData->Vorname, $mitglied->Vorname );
				
			if( $mitglied->Nachname != $testData->Name )
				return new ErrorMessage( 'Mitglied', 'ctor', 'Name falsch', $testData->Name, $mitglied->Name );
				
			if( $mitglied->Email != $testData->Email )
				return new ErrorMessage( 'Mitglied', 'ctor', 'Email falsch', $testData->Email, $mitglied->Email );
				
			if( $mitglied->Rechte != 1 )
				return new ErrorMessage( 'Mitglied', 'ctor', 'Email falsch', 1, $mitglied->Rechte );
				
			return true;
		}
	}
?>
