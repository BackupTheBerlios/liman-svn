<?php
	define("SQLDB", "mysql");

	/*! \brief Datenbankzugriff über MySQL
	 *
	 *  Erlaubt den abstrahierten Zugriff über SQL auf eine
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
		function SQLDB($host, $user, $password, $database, $persist = true);
		
		/*! \brief Beendet Verbindung
		 *
		 *  Beendet die Verbindung zum Datenbankserver, wenn eine nicht
		 *  persistende Verbindung besteht.
		 *  \pre -
		 *  \retval true bei Erfolg
		 *  \retval false bei Misserfolg
		 *  \remarks Persistente Verbindungen werden nicht geschlossen
		 */
		function Close();
		
		/*! \brief Springt auf Datensatz
		 *
		 *  Lässt den internen Zeiger auf angegebenen Datensatz der
		 *  letzten Anfrage zeigen. Der Datensatz lässt sich danach mit
		 *  Fetch abfragen.
		 *  \pre Datenbankverbindung muss mit einer Abfrage bestehen
		 *  \retval true bei Erfolg
		 *  \retval false bei Misserfolg
		 */
		function DataSeek($row_number);
		
		/*! \brief Liefert Datensatz als Objekt
		 *
		 *  Wandelt aktuellen Datensatz in Objekt um und gibt ihn
		 *  zurück. Nach erfolgreicher Operation wird der
		 *  interne Zeiger eine Stelle weiter gerückt.
		 *  \pre Datenbankverbindung muss mit einer Abfrage bestehen
		 *  \return bei Erfolg Datensatz als Objekt
		 *  \retval false bei Misserfolg
		 */
		function Fetch();
		
		/*! \brief Entfernt Ergebnisse
		 *
		 *  Entfernt Datensätze der letzten Anfrage und gibt deren
		 *  Speicher frei.
		 *  \pre -
		 *  \remarks Funktion wird vor jedem Query() aufgerufen
		 */
		function FreeResult();
		
		/*! \brief Anzahl zuletzt geänderter Datensätze
		 *
		 *  Gibt Anzahl der bei der letzten INSERT, UPDATE bzw. DELETE
		 *  Anweisung geänderten Datensätze.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \return Anzahl der Datensätze
		 *  \remarks Für gefundene Datensätze sollte GetNumRows() genutzt werden
		 */
		function GetAffectedRows();
		
		/*! \brief Liefert Fehlerinformationen
		 *
		 *  Liefert Feld mit Fehlernachricht und interner Fehlernummer
		 *  zurück.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \return Feld mit feld[0] als Fehlernachricht und feld[1] als Fehlernummer
		 */
		function GetError();

		/*! \brief Liefert die ID des letzten INSERTS
		 *
		 *  Liefert die ID des bei den letzten INSERT angelegten
		 *  Datensatzes zurück
		 *  \pre Datenbankverbindung muss bestehen
		 *  \pre INSERT-Query muss gemacht worden sein
		 *  \return ID des zuletzt hinzugefügten Datensatzes
		 *  \retval false bei Misserfolg
		 */
		function GetInsertID();
		
		/*! \brief Anzahl zuletzt gefundener Datensätze
		 *
		 *  Gibt Anzahl der bei der letzten SELECT-Anweisung
		 *  gefundenen Datensätze.
		 *  \pre Datenbankverbindung muss mit einer Abfrage bestehen
		 *  \return bei Erfolg Anzahl der Datensätze
		 *  \retval false bei Misserfolg
		 *  \remarks Für geänderte Datensätze sollte GetAffectedRows() genutzt werden
		 */
		function GetNumRows();
		
		/*! \brief Sendet Anfrage an Server
		 *
		 *  Sendet eine Anfrage an die aktive Datenbank.
		 *  Erhaltene Datensätze der Anfrage können mit Fetch abgefragt
		 *  werden.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $query SQL-Anfrage an den Datenbankserver
		 *  \retval false wenn ein Fehler in der Anfrage aufgetreten ist
		 */
		function Query($query);
	}
?>
