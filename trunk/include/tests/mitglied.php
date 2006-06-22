<?php
	require_once("include/tests/errormessage.php");
	
	class MitgliedTest
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
			
			$sqldb->Verify();
			$login->Level = $this->login->Level;
			$login->Nr = $this->login->Nr;
		}
		
		function CreateMemberData( $nr, $login, $pass, $firstName, $name, $email, $rights )
		{
			$data = new stdClass();
			$data->Nr = $nr;
			$data->Login = $login;
			$data->Passwort = Mitglied::PasswordHash($pass);
			$data->Vorname = $firstName;
			$data->Nachname = $name;
			$data->Email = $email;
			$data->Rechte = $rights;
			return $data;
		}
		
		function ConstructorTest()
		{
			global $sqldb;
			
			$testData = CreateMemberData( 1, "Maximator", "passwort","Max", "Mustermann", "max.mustermann@gmx.de", "Benutzer" );
			
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
		
		function Delete()
		{
			global $sqldb, $login;
			
			$login->Rechte = 1;		// Test mit Mitglied-Rechten
			
			$delResult = Mitglied::Delete( 1 );
			$dbResult = $sqldb->Verify();
			
			if( $dbResult !== true)
			{
				$dbResult->Unit = 'Mitglied';
				$dbResult->Test = 'Delete (Mitglied)';
				return $dbResult;
			}
			
			if( $delResult !== false )	//	< Admin darf nicht l�schen
			{
				return new ErrorMessage( 'Mitglied', 'Delete (Mitglied)', 'R�ckgabewert', false, $delResult );
			}
			
			// ------------------------------------------------
			
			$login->Rechte = 2;		// Test mit Admin-Rechten
			
			$sqldb->ExpectQuery( 'DELETE FROM.*Mitglieder.*WHERE', 1 );
			
			$delResult = Mitglied::Delete( 1 );
			$dbResult = $sqldb->Verify();
			
			if( $dbResult !== true)
			{
				$dbResult->Unit = 'Mitglied';
				$dbResult->Test = 'Delete (Mitglied)';
				return $dbResult;
			}
			
			if( $delResult !== true )	// Admin darf l�schen
			{
				return new ErrorMessage( 'Mitglied', 'Delete (Admin)', 'R�ckgabewert', true, $delResult );
			}
			
			return true;
		}
		
		function Insert()
		{
			global $sqldb, $login;
			
			$login->Rechte = 1;		// Test mit Mitglied-Rechten
			
			$insResult = Mitglied::Insert( 1, "Maximator", "passwort", "Max", "Mustermann", "max.mustermann@gmx.de", "Benutzer" );
			$dbResult = $sqldb->Verify();
			
			if( $dbResult !== true)
			{
				$dbResult->Unit = 'Mitglied';
				$dbResult->Test = 'Insert (Mitglied)';
				return $dbResult;
			}
			
			if( $insResult !== false )	//	< Admin darf nicht hinzuf�gen
			{
				return new ErrorMessage( 'Mitglied', 'Insert (Mitglied)', 'R�ckgabewert', false, $insResult );
			}
			
			// ------------------------------------------------
			
			$login->Rechte = 2;		// Test mit Admin-Rechten
			
			$sqldb->ExpectQuery( 'INSERT INTO.*Mitglieder.*VALUES', 1 );
			
			$insResult = Mitglied::Insert( 1, "Maximator", "passwort", "Max", "Mustermann", "max.mustermann@gmx.de", "Benutzer" );
			$dbResult = $sqldb->Verify();
			
			if( $dbResult !== true)
			{
				$dbResult->Unit = 'Mitglied';
				$dbResult->Test = 'Insert (Mitglied)';
				return $dbResult;
			}
			
			if( $insResult !== true )	// Admin darf hinzuf�gen
			{
				return new ErrorMessage( 'Mitglied', 'Insert (Admin)', 'R�ckgabewert', true, $insResult );
			}
			
			return true;
		}
		
		function Update()
		{
			global $sqldb, $login;
			
			$login->Rechte = 1;	// Test mit Mitglied-Rechten
			$login->Nr = 3;		// aber falscher Nummer
			$updResult = Mitglied::Update( 1, "Maximator", "passwort", "Max", "Mustermann", "max.mustermann@gmx.de", "Benutzer" );
			
			$dbResult = $sqldb->Verify();
			
			if( $dbResult !== true)
			{
				$dbResult->Unit = 'Mitglied';
				$dbResult->Test = 'Update (anderes Mitglied)';
				return $dbResult;
			}
			
			if( $updResult !== false )	// fremder Nutzer darf nicht editieren
			{
				return new ErrorMessage( 'Mitglied', 'Update (Gast)', 'R�ckgabewert', false, $updResult );
			}
			
			// ------------------------------------------------
			
			$login->Rechte = 1;	// Test mit Mitglied-Rechten
			$login->Nr = 1;		// richtige Nummer
			$sqldb->ExpectQuery( 'UPDATE.*Mitglieder.*WHERE', 1 );
			
			$updResult = Mitglied::Update( 1, "Maximator", "passwort", "Max", "Mustermann", "max.mustermann@gmx.de", "Benutzer" );
			
			$dbResult = $sqldb->Verify();
			
			if( $dbResult !== true)
			{
				$dbResult->Unit = 'Mitglied';
				$dbResult->Test = 'Update (selbst)';
				return $dbResult;
			}
			
			if( $updResult !== true )	// man darf sich selbst editieren
			{
				return new ErrorMessage( 'Mitglied', 'Update (Gast)', 'R�ckgabewert', true, $updResult );
			}
			
			// ------------------------------------------------
			
			$login->Rechte = 1;	// Test mit Administrator-Rechten
			$login->Nr = 2;		// andere Nummer
			$sqldb->ExpectQuery( 'UPDATE.*Mitglieder.*WHERE', 1 );
			
			$updResult = Mitglied::Update( 1, "Maximator", "passwort", "Max", "Mustermann", "max.mustermann@gmx.de", "Benutzer" );
			
			$dbResult = $sqldb->Verify();
			
			if( $dbResult !== true)
			{
				$dbResult->Unit = 'Mitglied';
				$dbResult->Test = 'Update (Admin)';
				return $dbResult;
			}
			
			if( $updResult !== true )	// Admin darf alle editieren
			{
				return new ErrorMessage( 'Mitglied', 'Update (Gast)', 'R�ckgabewert', true, $updResult );
			}
			
			return true;
		}
		
		function GetAll()
		{
			global $sqldb, $login;
			
			$queryResult = array();
			$queryResult[] = CreateMemberData( 1, "Maximator", "passwort", "Max", "Mustermann", "max.mustermann@gmx.de", "Benutzer" ); 
			$queryResult[] = CreateMemberData( 2, "FischerFritze", "passwort", "Fritz", "fischer", "fritz@fischer.net", "Administrator" );
			
			$login->Level = 0;	// Test mit Gast-Rechten
			
			$members = Mitglied::GetAll();
			$dbResult = $sqldb->Verify();
			
			if( $dbResult !== true )
			{
				$dbResult->Unit = 'Mitglied';
				$dbResult->Test = 'GetAll (Gast)';
				return $dbResult;
			}
			
			if( count($members) != 0 )	// Gast bekommt keine Anzeige
				return new ErrorMessage( 'Mitglied', 'GetAll (Gast)', 'Anzahl Mitglieder', 0, count($members) );
				
			// ------------------------------------------------
			
			$login->Nr = 1;
			$login->Level = 1;	// Test mit Mitglied-Rechten
			
			$sqldb->ExpectQuery( "SELECT.*FROM.*Mitglieder.*WHERE.*Mitglieds_Nr\\s*=\\s*'1'", $queryResult[0] );
			
			$members = Mitglied::GetAll();
			$dbResult = $sqldb->Verify();

			if( $dbResult !== true )
			{
				$dbResult->Unit = 'Mitglied';
				$dbResult->Test = 'GetAll (Mitglied)';
				return $dbResult;
			}
			
			if( count($members) != 1 )	// Mitglied bekommt nur sich selbst
				return new ErrorMessage( 'Mitglied', 'GetAll (Mitglied)', 'Anzahl Mitglieder', 1, count($members) );
				
			if( $members[0]->Nr != 1 )	// nur einer wird angezeigt (Mitglied selbst)
				return new ErrorMessage( 'Mitglied', 'GetAll (Mitglied)', 'Mitgliedsnummer', 1, $members[0]->Nr );
				
			// ------------------------------------------------
			
			$login->Nr = 2;
			$login->Level = 2;	// Test mit Admin-Rechten
			
			$sqldb->ExpectQuery( 'SELECT.*FROM.*Mitglieder', $queryResult );
			
			$members = Mitglied::GetAll();
			$dbResult = $sqldb->Verify();
			
			if( $dbResult !== true )
			{
				$dbResult->Unit = 'Mitglied';
				$dbResult->Test = 'GetAll (Admin)';
				return $dbResult;
			}
			
			if( count($members) != count($queryResult) )	// alle werden angezeigt
				return new ErrorMessage( 'Mitglied', 'GetAll (Admin)', 'Anzahl Mitglieder', count($queryResult), count($members) );
				
			return true;
		}
	}
?>
