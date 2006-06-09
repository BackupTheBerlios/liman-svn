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
		 *  L�sst den internen Zeiger auf angegebenen Datensatz der
		 *  letzten Anfrage zeigen. Der Datensatz l�sst sich danach mit
		 *  Fetch abfragen.
		 *  \pre Datenbankverbindung muss mit einer Abfrage bestehen
		 *  \retval true bei Erfolg
		 *  \retval false bei Misserfolg
		 */
		function DataSeek($row_number);
		
		/*! \brief Liefert Datensatz als Objekt
		 *
		 *  Wandelt aktuellen Datensatz in Objekt um und gibt ihn
		 *  zur�ck. Nach erfolgreicher Operation wird der
		 *  interne Zeiger eine Stelle weiter ger�ckt.
		 *  \pre Datenbankverbindung muss mit einer Abfrage bestehen
		 *  \return bei Erfolg Datensatz als Objekt
		 *  \retval false bei Misserfolg
		 */
		function Fetch();
		
		/*! \brief Entfernt Ergebnisse
		 *
		 *  Entfernt Datens�tze der letzten Anfrage und gibt deren
		 *  Speicher frei.
		 *  \pre -
		 *  \remarks Funktion wird vor jedem Query() aufgerufen
		 */
		function FreeResult();
		
		/*! \brief Anzahl zuletzt ge�nderter Datens�tze
		 *
		 *  Gibt Anzahl der bei der letzten INSERT, UPDATE bzw. DELETE
		 *  Anweisung ge�nderten Datens�tze.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \return Anzahl der Datens�tze
		 *  \remarks F�r gefundene Datens�tze sollte GetNumRows() genutzt werden
		 */
		function GetAffectedRows();
		
		/*! \brief Liefert Fehlerinformationen
		 *
		 *  Liefert Feld mit Fehlernachricht und interner Fehlernummer
		 *  zur�ck.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \return Feld mit feld[0] als Fehlernachricht und feld[1] als Fehlernummer
		 */
		function GetError();

		/*! \brief Liefert die ID des letzten INSERTS
		 *
		 *  Liefert die ID des bei den letzten INSERT angelegten
		 *  Datensatzes zur�ck
		 *  \pre Datenbankverbindung muss bestehen
		 *  \pre INSERT-Query muss gemacht worden sein
		 *  \return ID des zuletzt hinzugef�gten Datensatzes
		 *  \retval false bei Misserfolg
		 */
		function GetInsertID();
		
		/*! \brief Anzahl zuletzt gefundener Datens�tze
		 *
		 *  Gibt Anzahl der bei der letzten SELECT-Anweisung
		 *  gefundenen Datens�tze.
		 *  \pre Datenbankverbindung muss mit einer Abfrage bestehen
		 *  \return bei Erfolg Anzahl der Datens�tze
		 *  \retval false bei Misserfolg
		 *  \remarks F�r ge�nderte Datens�tze sollte GetAffectedRows() genutzt werden
		 */
		function GetNumRows();
		
		/*! \brief Sendet Anfrage an Server
		 *
		 *  Sendet eine Anfrage an die aktive Datenbank.
		 *  Erhaltene Datens�tze der Anfrage k�nnen mit Fetch abgefragt
		 *  werden.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $query SQL-Anfrage an den Datenbankserver
		 *  \retval false wenn ein Fehler in der Anfrage aufgetreten ist
		 */
		function Query($query);
	}
?>
