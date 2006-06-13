<?php
	require_once("include/login.php");

	/*! \brief Verwaltet Kommentare
	 *
	 *  Stellt Funktionen zum Anlegen, L�schen, Bearbeiten von Kommentaren
	 *  bereit. Es k�nnen sowohl einzelne Kommentare oder Kommentare nach
	 *  ihrer Verbindung zur Literatur bzw. Mitgliedern gel�scht werden.
	 *  \pre Datenbankverbindung muss bestehen
	 *  \sa
	 *  - Login::IsAdministrator
	 *  - Login::IsMember
	 *  - SQLDB::Query
	 *  - SQLDB::Fetch
	 *
	 *  \author Frank Wilhelm
	 *  \date 30.05.2006
	 */
	class Kommentar
	{
		var $Nr = 0; ///< Identifikationsnummer des Kommentars
		var $Text = 0; ///< Kommentartext
		var $Verfasser_Nr = 0; ///< Mitglieds_Nr des Verfassers
		var $Verfasser_Name = 0; ///< Name des Verfassers (Vor- und Nachname)
		
		/*! \brief Legt Kommentarobjekt an
		 *
		 *  Legt ein neues Kommentarobjekt aus einem Objekt mit den
		 *  Attributen Nr, Text, Verfasser_Nr und Verfasser_Name an.
		 *  \pre -
		 *  \param[in] $data Objekt mit Kommentardaten der Form
		 *    - Nr
		 *    - Text
		 *    - Mitglieds_Nr
		 *    - Vorname
		 *    - Nachname
		 */
		function Kommentar($data);
		
		/*! \brief L�scht Kommentar
		 *
		 *  L�scht einen Kommentar aus Kommentare mit der Kommentar_Nr
		 *  $nr.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \pre Kommentar in Kommentare mit Kommentar_Nr $nr muss
		 *    existieren
		 *  \param[in] $nr Nummer des zu l�schenden Kommentars
		 *  \remarks Ist der Nutzer nicht als Administrator angemeldet,
		 *    werden keine Operationen ausgef�hrt, wenn Mitglieds_Nr
		 *    des Kommentars ungleich der eigenen Mitglieds_Nr ist.
		 *    Ist der Nutzer nicht angemeldet, werden keine Operationen
		 *    ausgef�hrt
		 */
		function Delete($nr);
		
		/*! \brief L�scht alle zu einer Literatur geh�renden Kommentare
		 *
		 *  L�scht alle Kommentare aus Kommentare, die mit Literatur
		 *  mit der Literaturnummer ($literatur_nr) verbunden sind.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $literatur_nr Nummer der Literatur
		 *  \remarks Ist Nutzer nicht eingeloggt, werden keine
		 *    Operationen ausgef�hrt.
		 */
		function DeleteAll($literatur_nr);

		/*! \brief L�scht alle zu einem Mitglied geh�renden Kommentare
		 *
		 *  L�scht alle Kommentare aus Kommentare, die mit Mitglieder
		 *  mit der Mitglieds_Nr ($member_nr) verbunden sind.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $member_nr Nummer eines Mitglieds
		 *  \remarks Ist der Nutzer nicht als Administrator eingeloggt,
		 *    werden keine Operationen ausgef�hrt.
		 */
		function DeleteAllMember($member_nr);

		/*! \brief Gibt Kommentare zu bestimmter Literatur zur�ck
		 *
		 *  Liest alle Kommentare die einer Literatur ($literatur_nr)
		 *  zugeordnet sind aus Kommentare aus und gibt sie als Feld des
		 *  Typs Kommentar zur�ck.
		 *  \param[in] $literatur_nr Nr einer Literatur mit Kommentaren
		 *  \pre Datenbankverbindung muss bestehen
		 *  \return Feld mit Elementen vom Typ Kommentar
		 */
		function GetAll($literatur_nr);
		
		/*! \brief Legt Kommentar an
		 *
		 *  Legt einen neuen Kommentar mit Text ($text) zu einer
		 *  Literatur ($literatur_nr) vom einem Verfasser 
		 *  ($verfasser_nr) an.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \pre Text ($text) darf nicht leer sein
		 *  \param[in] $text Text des Kommentars
		 *  \param[in] $verfasser_nr Mitglieds_Nr des Verfassers
		 *  \param[in] $literatur_nr Nummer der Literatur
		 *  \remarks Ist das aktuelle Mitglied kein 
		 *  Administrator, dann muss $verfasser_nr gleich der aktuellen
		 *  Nummer des Logins sein. Ist der Nutzer nicht eingeloggt,
		 *  werden keine Operationen ausgef�hrt. Ist keine passende
		 *  Literatur mit der Literatur_Nr $literatur_nr vorhanden,
		 *  wird kein Kommentar angelegt. Existiert schon ein Kommentar
		 *  zu Literatur mit $literatur_nr von Mitglied mit Mitglieds_Nr
		 *  $verfasser_nr, wird nur der Text des Kommentars mit
		 *  Kommentar::Update ge�ndert.
		 */
		function Insert($text, $verfasser_nr, $literatur_nr);
		
		/*! \brief �ndert einen Kommentar
		 *
		 *  �ndert in Kommentare den Text des Kommentars mit $nr
		 *  in $text.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \pre Kommentar in Kommentare mit Kommentar_Nr $nr muss
		 *    existieren
		 *  \param[in] $nr Nummer des zu ver�ndernden Kommentars
		 *  \param[in] $text neuer Text des Kommentars
		 *  \remarks Ist das aktuelle Mitglied kein Administrator,
		 *  dann muss die aktuelle Nummer des Mitglieds gleich der
		 *  Mitglieds_Nr des Kommentars in Kommentare sein. Ist der
		 *  Nutzer nicht eingeloggt, werden keine Operationen
		 *  ausgef�hrt. Wird kein Text ($text) angegeben, wird der
		 *  Kommentar mit Kommentar::Delete gel�scht.
		 */
		function Update($nr, $text);
	}
?>
