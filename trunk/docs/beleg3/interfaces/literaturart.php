<?php
	/*! \brief Verwaltet Literaturarten
	 *
	 *  Verwaltet die aus der Datenbank oder BibTeX-Datei erhaltenen
	 *  Informationen zur Art einer Literatur. Enthaltene Informationen
	 *  können wieder als BibTeX- oder als der in Datenbank/Benutzeroberfläche
	 *  verwendeten Namen zurückgegeben werden.
	 *  \pre -
	 *
	 *  \author Frank Wilhelm
	 *  \date 30.05.2006
	 */
	class LiteraturArt
	{
		/*! \brief Importiert BibTeX- bzw. interne Namen
		 *
		 *  Importiert die in BibTeX-Dateien oder in der
		 *  Datenbank/Benutzeroberflächen verwendeten Bezeichner für
		 *  Literaturarten und weist sie einen internen Wert zu.
		 *  \pre -
		 *  \param[in] $text BibTeX oder interner Bezeichner einer Literaturart
		 *  \remarks Ist der Bezeichner unbekannt, erhält die Literatur
		 *    die Art "Sonstiges"
		 */
		function LiteraturArt($text);
		
		/*! \brief Liefert Bezeichner für Datenbank/Benutzeroberfläche
		 *
		 *  Je nach der bei der Erstellung des Objekts gewählten Art,
		 *  wird der dazugehörige Bezeichner für die Literaturart
		 *  in der Datenbank/Benutzeroberfläche herausgesucht.
		 *  \pre -
		 *  \return String mit Bezeichner der Literaturart in
		 *    Datenbank/Benutzeroberflächendarstellung
		 *  \remarks Sollte der Wert der Literatur nicht bekannt sein
		 *    wird "Sonstiges" zurückgegeben
		 */
		function GetDisplayText();
		
		/*! \brief Liefert Bezeichner für BibTeX
		 *
		 *  Je nach der bei der Erstellung des Objekts gewählten Art,
		 *  wird der dazugehörige Bezeichner für die Literaturart
		 *  in BibTeX herausgesucht.
		 *  \pre -
		 *  \return String mit Bezeichner der Literaturart in
		 *    BibTeX-Darstellung
		 *  \remarks Sollte der Wert der Literatur nicht bekannt sein
		 *    wird "Sonstiges" zurückgegeben
		 */
		function GetBibtexText();
	}
?>
