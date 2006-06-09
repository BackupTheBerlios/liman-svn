<?php
	/*! \brief Verwaltet Literaturarten
	 *
	 *  Verwaltet die aus der Datenbank oder BibTeX-Datei erhaltenen
	 *  Informationen zur Art einer Literatur. Enthaltene Informationen
	 *  k�nnen wieder als BibTeX- oder als der in Datenbank/Benutzeroberfl�che
	 *  verwendeten Namen zur�ckgegeben werden.
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
		 *  Datenbank/Benutzeroberfl�chen verwendeten Bezeichner f�r
		 *  Literaturarten und weist sie einen internen Wert zu.
		 *  \pre -
		 *  \param[in] $text BibTeX oder interner Bezeichner einer Literaturart
		 *  \remarks Ist der Bezeichner unbekannt, erh�lt die Literatur
		 *    die Art "Sonstiges"
		 */
		function LiteraturArt($text);
		
		/*! \brief Liefert Bezeichner f�r Datenbank/Benutzeroberfl�che
		 *
		 *  Je nach der bei der Erstellung des Objekts gew�hlten Art,
		 *  wird der dazugeh�rige Bezeichner f�r die Literaturart
		 *  in der Datenbank/Benutzeroberfl�che herausgesucht.
		 *  \pre -
		 *  \return String mit Bezeichner der Literaturart in
		 *    Datenbank/Benutzeroberfl�chendarstellung
		 *  \remarks Sollte der Wert der Literatur nicht bekannt sein
		 *    wird "Sonstiges" zur�ckgegeben
		 */
		function GetDisplayText();
		
		/*! \brief Liefert Bezeichner f�r BibTeX
		 *
		 *  Je nach der bei der Erstellung des Objekts gew�hlten Art,
		 *  wird der dazugeh�rige Bezeichner f�r die Literaturart
		 *  in BibTeX herausgesucht.
		 *  \pre -
		 *  \return String mit Bezeichner der Literaturart in
		 *    BibTeX-Darstellung
		 *  \remarks Sollte der Wert der Literatur nicht bekannt sein
		 *    wird "Sonstiges" zur�ckgegeben
		 */
		function GetBibtexText();
	}
?>
