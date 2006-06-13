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
		/*! Typ des Buches
		 *   - 1 Buch
		 *   - 2 Artikel
		 *   - 3 Brosch�re
		 *   - 4 Protokoll
		 *   - 5 Anleitung
		 *   - 6 Diplomarbeit
		 *   - 7 Dissertation
		 *   - 8 Techn. Bericht
		 *   - 9 Unver�ffentlicht
		 *   - sonst Sonstiges
		 *  \private
		 */
		var $value = 0;
		
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
		function LiteraturArt($text)
		{
			// Suche Zahlenrepr�sentation des �bergebenen Texts heraus
			switch ($text)
			{
			case "book":
			case "inbook":
			case "Buch":
				$this->value = 1;
				break;

			case "Artikel":
			case "article":
				$this->value = 2;
				break;

			case "Brosch�re":
			case "booklet":
				$this->value = 3;
				break;
		
			case "Protokoll":
			case "proceedings":
			case "inproceedings":
			case "conference":
				$this->value = 4;
				break;

			case "Anleitung":
			case "manual":
				$this->value = 5;
				break;

			case "Diplomarbeit":
			case "masterthesis":
				$this->value = 6;
				break;

			case "Dissertation":
			case "phdthesis":
				$this->value = 7;
				break;

			case "Techn. Bericht":
			case "techreport":
				$this->value = 8;
				break;

			case "Unver�ffentlicht":
			case "unpublished":
				$this->value = 9;
				break;

			default:
			case "Sonstiges":
			case "misc":
				$this->value = 0;
			};
		}
		
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
		function GetDisplayText()
		{
			// Suche Datenbank-/Benutzeroberfl�chetext herau
			switch ($this->value)
			{
			case 1:
				return "Buch";

			case 2:
				return "Artikel";

			case 3:
				return "Brosch�re";
		
			case 4:
				return "Protokoll";

			case 5:
				return "Anleitung";

			case 6:
				return "Diplomarbeit";

			case 7:
				return "Dissertation";

			case 8:
				return "Techn. Bericht";

			case 9:
				return "Unver�ffentlicht";

			default:
			case 0:
				return "Sonstiges";
			};
		}
		
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
		function GetBibtexText()
		{
			// Suche BibTeX-Text heraus
			switch ($this->value)
			{
			case 1:
				return "book";

			case 2:
				return "article";

			case 3:
				return "booklet";
		
			case 4:
				return "proceedings";

			case 5:
				return "manual";

			case 6:
				return "masterthesis";

			case 7:
				return "phdthesis";

			case 8:
				return "techreport";

			case 9:
				return "unpublished";

			default:
			case 0:
				return "misc";
			};
		}
	}
?>
