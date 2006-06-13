<?php
	define("SQLDB", "mysql");

	/*! \brief Datenbankzugriff �ber MySQL
	 *
	 *  Erlaubt den abstrahierten Zugriff �ber SQL auf eine
	 *  Datenbank (hier MySQL).
	 *  \pre -
	 *
	 *  \author Sven Eckelmann
	 *  \date 06.06.2006
	 */
	class SQLDB
	{
		var $db_id = false; ///< Identifikation der aktuellen Datenbankverbindung
		var $query_result = false; ///< Identifikation der letzten Datenbankabfrage
		

		/*! \brief �ffnet eine Datenbankverbindung
		 *
		 *  Startet eine Verbindung zum Datenbanksystem, je nach
		 *  gew�hlter Art ($persist), und w�hlt nach erfolgreichem
		 *  Aufbau eine Datenbank. Treten Fehler beim Aufbau auf, wird
		 *  SQLDB::$db_id auf false gesetzt.
		 *  \pre -
		 *  \param[in] $host Adresse oder IP des MySQL-Servers
		 *  \param[in] $user Benutzernamen f�r MySQL-Zugriff
		 *  \param[in] $password Benutzerpasswort f�r MySQL-Zugriff
		 *  \param[in] $database Auszuw�hlende Datenbank
		 *  \param[in] $persist Aufbau einer persistenten (geteilten) Verbindung
		 */
		function SQLDB($host, $user, $password, $database, $persist = true)
		{
			if ($persist == true)
			{
				$this->db_id = @mysql_pconnect($host, $user, $password);
			}
			else
			{
				$this->db_id = @mysql_connect($host, $user, $password);
			}
			
			if ($this->db_id !== false)
			{
				if (@mysql_select_db($database, $this->db_id) === false)
				{
					// Verbindung aufgebaut und Datenbank nicht ausgew�hlt
					@mysql_close($this->db_id);
					$this->db_id = false;
				}
			}
			else
			{
				// Verbindungsaufbau funktionierte nicht
				$this->db_id = false;
			}
		}
		
		/*! \brief Beendet Verbindung
		 *
		 *  Beendet die Verbindung zum Datenbankserver, wenn eine nicht
		 *  persistende Verbindung besteht.
		 *  \pre -
		 *  \retval true bei Erfolg
		 *  \retval false bei Misserfolg
		 *  \remarks Persistente Verbindungen werden nicht geschlossen
		 */
		function Close()
		{
			if ($this->db_id !== false)
			{
				// Wenn Datenbankverbindung besteht,
				// gebe Resourcen frei und schlie�e Verbindung
				$this->FreeResult();
				$dbid = $this->db_id;
				$this->db_id = false;
				return @mysql_close($dbid);
			}
			else
			{
				// keine Verbindung endet immer im geschlossenem
				// Zustand
				return true;
			}
		}
		
		/*! \brief Springt auf Datensatz
		 *
		 *  L�sst den internen Zeiger auf angegebenen Datensatz der
		 *  letzten Anfrage zeigen. Der Datensatz l�sst sich danach mit
		 *  Fetch abfragen.
		 *  \pre Datenbankverbindung muss mit einer Abfrage bestehen
		 *  \retval true bei Erfolg
		 *  \retval false bei Misserfolg
		 */
		function DataSeek($row_number)
		{
			if ($this->db_id !== false && $this->query_result !== false)
			{
				// Wenn Datenbankverbindung und Ergebnis eines Querys
				// besteht, bewege Zeiger auf angegebenes Ergebnis
				return @mysql_data_seek($this->query_result, $row_number);
			}
			else
			{
				return false;
			}
		}
		
		/*! \brief Liefert Datensatz als Objekt
		 *
		 *  Wandelt aktuellen Datensatz in Objekt um und gibt ihn
		 *  zur�ck. Nach erfolgreicher Operation wird der
		 *  interne Zeiger eine Stelle weiter ger�ckt.
		 *  \pre Datenbankverbindung muss mit einer Abfrage bestehen
		 *  \return bei Erfolg Datensatz als Objekt
		 *  \retval false bei Misserfolg
		 */
		function Fetch()
		{
			if ($this->db_id !== false && $this->query_result !== false)
			{
				// Wenn Datenbankverbindung und Ergebnis eines Querys
				// besteht, gebe aktuelles Ergebnis zur�ck
				return @mysql_fetch_object($this->query_result);
			}
			else
			{
				return false;
			}
		}
		
		/*! \brief Entfernt Ergebnisse
		 *
		 *  Entfernt Datens�tze der letzten Anfrage und gibt deren
		 *  Speicher frei.
		 *  \pre -
		 *  \remarks Funktion wird vor jedem Query() aufgerufen
		 */
		function FreeResult()
		{
			if ($this->query_result !== false)
			{
				// Wenn rgebnis eines Querys existiert, gebe
				// es frei
				$queryresult = $this->query_result;
				$this->query_result = false;
				return @mysql_free_result($queryresult);
			}
			else
			{
				// keine Resultate enden immer mit leeren
				// Resultaten
				return true;
			}
		}
		
		/*! \brief Anzahl zuletzt ge�nderter Datens�tze
		 *
		 *  Gibt Anzahl der bei der letzten INSERT, UPDATE bzw. DELETE
		 *  Anweisung ge�nderten Datens�tze.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \return Anzahl der Datens�tze
		 *  \remarks F�r gefundene Datens�tze sollte GetNumRows() genutzt werden
		 */
		function GetAffectedRows()
		{
			if ($this->db_id !== false)
			{
				// Wenn Datenbankverbindung besteht, gebe
				// Anzahl zuletzt ge�nderter Datens�tze zur�ck
				return @mysql_affected_rows($this->db_id);
			}
			else
			{
				return false;
			}
		}
		
		/*! \brief Liefert Fehlerinformationen
		 *
		 *  Liefert Feld mit Fehlernachricht und interner Fehlernummer
		 *  zur�ck.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \return Feld mit feld[0] als Fehlernachricht und feld[1] als Fehlernummer
		 */
		function GetError()
		{
			$error = array();
			if ($this->db_id !== false)
			{
				$error['msg'] = @mysql_error($this->db_id);
				$error['code'] = @mysql_errno($this->db_id);
				
			}
			else
			{
				$error['msg'] = "Keine Verbindung vorhanden";
				$error['code'] = 0;
			}

			return $error;
		}

		/*! \brief Liefert die ID des letzten INSERTS
		 *
		 *  Liefert die ID des bei den letzten INSERT angelegten
		 *  Datensatzes zur�ck
		 *  \pre Datenbankverbindung muss bestehen
		 *  \pre INSERT-Query muss gemacht worden sein
		 *  \return ID des zuletzt hinzugef�gten Datensatzes
		 *  \retval false bei Misserfolg
		 */
		function GetInsertID()
		{
			if ($this->db_id !== false)
			{
				// Wenn Datenbankverbindung besteht, gebe 
				// ID des zuletzt hinzugef�gten Datensatzes
				// zur�ck
				return @mysql_insert_id($this->db_id);
			}
			else
			{
				return false;
			}
		}
		
		/*! \brief Anzahl zuletzt gefundener Datens�tze
		 *
		 *  Gibt Anzahl der bei der letzten SELECT-Anweisung
		 *  gefundenen Datens�tze.
		 *  \pre Datenbankverbindung muss mit einer Abfrage bestehen
		 *  \return bei Erfolg Anzahl der Datens�tze
		 *  \retval false bei Misserfolg
		 *  \remarks F�r ge�nderte Datens�tze sollte GetAffectedRows() genutzt werden
		 */
		function GetNumRows()
		{
			if ($this->db_id !== false && $this->query_result !== false)
			{
				// Wenn Datenbankverbindung und Ergebnis eines Querys
				// besteht, gebe Anzahl gefundener Datens�tze zur�ck
				return @mysql_num_rows($this->query_result);
			}
			else
			{
				return false;
			}
		}
		
		/*! \brief Sendet Anfrage an Server
		 *
		 *  Sendet eine Anfrage an die aktive Datenbank.
		 *  Erhaltene Datens�tze der Anfrage k�nnen mit Fetch abgefragt
		 *  werden.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $query SQL-Anfrage an den Datenbankserver
		 *  \retval false wenn ein Fehler in der Anfrage aufgetreten ist
		 */
		function Query($query)
		{
			if ($this->db_id !== false)
			{
				// Wenn Datenbankverbindung besteht, sende
				// Abfrage an Datenbank
				$this->FreeResult();
				return $this->query_result = @mysql_query($query, $this->db_id);
			}
			else
			{
				return false;
			}
		}
	}
?>
