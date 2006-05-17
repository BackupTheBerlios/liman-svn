<?php
	if(!defined("SQLDB"))
	{
		define("SQLDB", "mysql");
		

		/*! \brief Datenbankzugriff über MySQL
		 *
		 *  Erlaubt den abstrahierten Zugriff über SQL auf eine
		 *  Datenbank (hier MySQL).
		 */
		class SQLDB
		{
			var $db_id = 0; ///< Identifikation der aktuellen Datenbankverbindung
			var $query_result = 0; ///< Identifikation der letzten Datenbankabfrage
			

			/*! \brief Öffnet eine Datenbankverbindung
			 *
			 *  \param $host Adresse oder IP des MySQL-Servers
			 *  \param $user Benutzernamen für MySQL-Zugriff
			 *  \param $password Benutzerpasswort für MySQL-Zugriff
			 *  \param $database Auszuwählende Datenbank
			 *  \param $persist Aufbau einer persistenten (geteilten) Verbindung
			 *  \return Kennung der Datenbankverbindung oder im Fehlerfall false
			 */
			function SQLDB($host, $user, $password, $database, $persist = true)
			{
				if (empty($database) === true)
				{
					// keine Datenbank angegeben
					$this->db_id = false;
					return false;
				}

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
					if (@mysql_select_db($database, $this->db_id))
					{
						// Verbindung aufgebaut und Datenbank ausgewählt
						return $this->db_id;
					}
				}

				// Verbindungsaufbau funktionierte nicht
				$this->db_id = false;
				return  false;
			}
			
			/*! \brief Beendet Verbindung
			 *
			 *  Beendet die Verbindung zum Datenbankserver
			 *  \return Bei Erfolg true, im Fehlerfall false
			 *  \remarks Persistente Verbindungen werden nicht geschlossen
			 */
			function Close()
			{
				return @mysql_close($this->db_id);
			}
			
			/*! \brief Springt auf Datensatz
			 *
			 *  Lässt den internen Zeiger auf angegebenen
			 *  Datensatz der letzten Anfrage zeigen. Der
			 *  Datensatz lässt sich danach mit Fetch abfragen.
			 *  \return Bei Erfolg true, im Fehlerfall false
			 */
			function DataSeek($row_number)
			{
				return @mysql_data_seek($this->query_result, $row_number);
			}
			
			/*! \brief Liefert Datensatz als Objekt
			 *
			 *  Wandelt aktuellen Datensatz in Objekt um und gibt
			 *  ihn zurück. Nach erfolgreicher Operation wird der
			 *  interne Zeiger eine Stelle weiter gerückt
			 *  \return Bei Erfolg Datensatz als Objekt, sonst false
			 */
			function Fetch()
			{
				return @mysql_fetch_object($this->query_result);
			}
			
			/*! \brief Entfernt Ergebnisse
			 *  
			 *  Entfernt Datensätze der letzten Anfrage und gibt
			 *  deren Speicher frei
			 *  \remarks Funktion wird vor jedem query aufgerufen
			 */
			function FreeResult()
			{
				$ret = @mysql_free_result($this->query_result);
				unset($this->query_result);
				return $ret;
			}
			
			/*! \brief Anzahl zuletzt geänderter Datensätze
			 *
			 *  Gibt Anzahl der bei der letzten INSERT, UPDATE bzw.
			 *  DELETE Anweisung geänderten Datensätze
			 *  \return Anzahl der Datensätze
			 *  \remarks Für gefundene Datensätze sollte num_rows() genutzt werden
			 */
			function GetAffectedRows()
			{
				return @mysql_affected_rows($this->db_id);
			}
			
			/*! \brief Liefert Fehlerinformationen
			 *
			 *  Liefert Array mit Fehlernachricht und interner
			 *  Fehlernummer zurück
			 *  \return Feld mit feld[0] als Fehlernachricht und feld[1] als Fehlernummer
			 */
			function GetError()
			{
				$error = array();
				$error['msg'] = @mysql_error($query_result);
				$error['code'] = @mysql_errno($query_result);
				return $error;
			}
			
			/*! \brief Anzahl zuletzt gefundener Datensätze
			 *
			 *  Gibt Anzahl der bei der letzten SELECT-Anweisung
			 *  gefundenen Datensätze
			 *  \return Anzahl der Datensätze
			 *  \remarks Für geänderte Datensätze sollte affected_rows() genutzt werden
			 */
			function GetNumRows()
			{
				return @mysql_num_rows($this->query_result);
			}
			
			/*! \brief Sendet Anfrage an Server
			 *
			 *  Sendet eine Anfrage an die aktive Datenbank.
			 *  Erhaltene Datensätze der Anfrage können mit Fetch
			 *  abgefragt  werden
			 *  \param $query SQL-Anfrage an den Datenbankserver
			 *  \return false wenn ein Fehler in der Anfrage aufgetreten ist
			 */
			function Query($query)
			{
				$this->free_result();
				return $this->query_result = @mysql_query($query, $this->db_id);
			}
		}
	}
?>