<?php
if(!defined("SQLDB"))
{
	define("SQLDB", "mysql");
	

	/*! \brief Datenbankzugriff über MySQL
	 *
	 *  Erlaubt den abstrahierten Zugriff über SQL auf eine
	 *  Datenbank (hier MySQL).
	 *  \pre -
	 */
	class SQLDB
	{
		var $db_id = false; ///< Identifikation der aktuellen Datenbankverbindung
		var $query_result = false; ///< Identifikation der letzten Datenbankabfrage
		

		/*! \brief Öffnet eine Datenbankverbindung
		 *
		 *  Startet eine Verbindung zum Datenbanksystem, je nach
		 *  gewählter Art ($persist), und wählt nach erfolgreichem
		 *  Aufbau eine Datenbank. Treten Fehler beim Aufbau auf, wird
		 *  SQLDB::$db_id auf false gesetzt.
		 *  \pre -
		 *  \param[in] $host Adresse oder IP des MySQL-Servers
		 *  \param[in] $user Benutzernamen für MySQL-Zugriff
		 *  \param[in] $password Benutzerpasswort für MySQL-Zugriff
		 *  \param[in] $database Auszuwählende Datenbank
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
					// Verbindung aufgebaut und Datenbank nicht ausgewählt
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
				$this->FreeResult();
				return @mysql_close($this->db_id);
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
		 *  Lässt den internen Zeiger auf angegebenen Datensatz der
		 *  letzten Anfrage zeigen. Der Datensatz lässt sich danach mit
		 *  Fetch abfragen.
		 *  \pre Datenbankverbindung muss mit einer Abfrage bestehen
		 *  \retval true bei Erfolg
		 *  \retval false bei Misserfolg
		 */
		function DataSeek($row_number)
		{
			if ($this->db_id !== false && $this->query_result !== false)
			{
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
		 *  zurück. Nach erfolgreicher Operation wird der
		 *  interne Zeiger eine Stelle weiter gerückt.
		 *  \pre Datenbankverbindung muss mit einer Abfrage bestehen
		 *  \return bei Erfolg Datensatz als Objekt
		 *  \retval false bei Misserfolg
		 */
		function Fetch()
		{
			if ($this->db_id !== false && $this->query_result !== false)
			{
				return @mysql_fetch_object($this->query_result);
			}
			else
			{
				return false;
			}
		}
		
		/*! \brief Entfernt Ergebnisse
		 *
		 *  Entfernt Datensätze der letzten Anfrage und gibt deren
		 *  Speicher frei.
		 *  \pre -
		 *  \remarks Funktion wird vor jedem query aufgerufen
		 */
		function FreeResult()
		{
			if ($this->query_result !== false)
			{
				return @mysql_free_result($this->query_result);;
			}
			else
			{
				// keine Resultate enden immer mit leeren
				// Resultaten
				return true;
			}
		}
		
		/*! \brief Anzahl zuletzt geänderter Datensätze
		 *
		 *  Gibt Anzahl der bei der letzten INSERT, UPDATE bzw. DELETE
		 *  Anweisung geänderten Datensätze.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \return Anzahl der Datensätze
		 *  \remarks Für gefundene Datensätze sollte num_rows() genutzt werden
		 */
		function GetAffectedRows()
		{
			if ($this->db_id !== false)
			{
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
		 *  zurück.
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
		
		/*! \brief Anzahl zuletzt gefundener Datensätze
		 *
		 *  Gibt Anzahl der bei der letzten SELECT-Anweisung
		 *  gefundenen Datensätze.
		 *  \pre Datenbankverbindung muss mit einer Abfrage bestehen
		 *  \return bei Erfolg Anzahl der Datensätze
		 *  \retval false bei Misserfolg
		 *  \remarks Für geänderte Datensätze sollte affected_rows() genutzt werden
		 */
		function GetNumRows()
		{
			if ($this->db_id !== false && $this->query_result !== false)
			{
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
		 *  Erhaltene Datensätze der Anfrage können mit Fetch abgefragt
		 *  werden.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $query SQL-Anfrage an den Datenbankserver
		 *  \retval false wenn ein Fehler in der Anfrage aufgetreten ist
		 */
		function Query($query)
		{
			if ($this->db_id !== false)
			{
				$this->FreeResult();
				return $this->query_result = @mysql_query($query, $this->db_id);
			}
			else
			{
				return false;
			}
		}
	}
}
?>
