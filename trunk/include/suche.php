<?php
if(!defined("Suche"))
{
	define("Suche", 1);
	require_once("literatur.php");

	/*! \brief Suche Literaturdaten
	 *
	 *  Durchsucht die Literatur- und Autorentabelle über Volltextsuche,
	 *  nach Autor und Titel oder nach den 10 zuletzt hinzugefügten
	 *  Literatureinträgen und speichert sie in $Treffer zwischen.
	 *  \pre Datenbankverbindung muss bestehen
	 */
	class Suche
	{
		/*! \brief gefundene Treffer
		 *
		 *  Feld aus gefundenen Trefferobjekten mit Attributen
		 *   - Nr
		 *   - Titel
		 *   - Autor
		 *   - Verlag
		 *   - ISBN
		 */
		var $Treffer = array();

		/*! \brief Sucht zuletzt hinzugefügte Literatur
		 *
		 *  Sucht in Literaturtabelle nach den 10 zuletzt hinzugefügten
		 *  Literatureinträgen und speichert Nr, Titel, Autor, Verlag
		 *  und ISBN als als Objekt im Feld $Treffer. Sollte ein Fehler
		 *  auftreten oder bisher keine Einträge vorhanden sein, dann
		 *  wird $Treffer ein Feld der Länge 0.
		 *  \pre Datenbankverbindung muss bestehen.
		 *  \private
		 */
		function LetzteLiteratur()
		{
			/// \todo implementieren
			$this->Treffer = array();
			$cur1->Nr = 1;
			$cur1->Titel = "Algorithmen";
			$cur1->Autor = "Sedgewick";
			$cur1->Verlag = "Pearson Studium";
			$cur1->ISBN = "3-8273-7032-9";
			$this->Treffer[] = $cur1;

			$cur2->Nr = 2;
			$cur2->Titel = "Python - kurz und gut";
			$cur2->Autor = "Mark Lutz";
			$cur2->Verlag = "O'Reilly";
			$cur2->ISBN = "3-89721-240-4";
			$this->Treffer[] = $cur2;
		}

		/*! \brief Sucht nach Literatur mit Suchbegriff
		 *
		 *  Sucht in Literatur und Autortabelle nach dem Auftreten
		 *  des übergebenen Textes in  Literatureinträgen und speichert
		 *  Nr, Titel, Autor, Verlag und ISBN als als Objekt im Feld
		 *  $Treffer. Sollte ein Fehler auftreten oder keine passenden
		 *  Einträge vorhanden sein, dann wird $Treffer ein Feld der
		 *  Länge 0.
		 *  \pre Datenbankverbindung muss bestehen.
		 *  \param[in] $volltext Suchtext
		 *  \private
		 */
		function VolltextSuche($volltext)
		{
			/// \todo implementieren
			$this->Treffer = array();
			$cur1->Nr = 1;
			$cur1->Titel = "Algorithmen";
			$cur1->Autor = "Sedgewick";
			$cur1->Verlag = "Pearson Studium";
			$cur1->ISBN = "3-8273-7032-9";
			$this->Treffer[] = $cur1;

			$cur2->Nr = 3;
			$cur2->Titel = "Angewandte Kryptographie";
			$cur2->Autor = "Bruce Schneier";
			$cur2->Verlag = "Addison-Wesley";
			$cur2->ISBN = "3-89319-854-7";
			$this->Treffer[] = $cur2;
		}
		
		/*! \brief Sucht Literatur mit Autor und Titel
		 *
		 *  Sucht in Literatur und Autortabelle nach dem Auftreten
		 *  von $autor in Autor und $titel im Titel des Literatureintrags
		 *  und speichert Nr, Titel, Autor, Verlag und ISBN der Treffer
		 *  als als Objekt im Feld $Treffer. Sollte ein Fehler auftreten
		 *  oder keine passenden Einträge vorhanden sein, dann wird
		 *  $Treffer ein Feld der Länge 0.
		 *  \pre Datenbankverbindung muss bestehen.
		 *  \param[in] $autor String mit Autorname
		 *  \param[in] $titel String mit Literaturtitel
		 *  \private
		 */
		function AutorTitelSuche($autor, $titel)
		{
			/// \todo implementieren
			$this->Treffer = array();
			$cur1->Nr = 2;
			$cur1->Titel = "Python - kurz und gut";
			$cur1->Autor = "Mark Lutz";
			$cur1->Verlag = "O'Reilly";
			$cur1->ISBN = "3-89721-240-4";
			$this->Treffer[] = $cur1;

			$cur2->Nr = 3;
			$cur2->Titel = "Angewandte Kryptographie";
			$cur2->Autor = "Bruce Schneier";
			$cur2->Verlag = "Addison-Wesley";
			$cur2->ISBN = "3-89319-854-7";
			$this->Treffer[] = $cur2;
		}

		
		/*! \brief Sucht Literatur
		 *
		 *  Wenn keine Parameter übergeben werden:
		 *  - Sucht in Literaturtabelle nach den 10 zuletzt hinzugefügten
		 *    Literatureinträgen und speichert Nr, Titel, Autor, Verlag
		 *    und ISBN als als Objekt im Feld $Treffer. Sollte ein Fehler
		 *    auftreten oder bisher keine Einträge vorhanden sein, dann
		 *    wird $Treffer ein Feld der Länge 0.
		 *
		 *  Wenn ein $suchbegriff übergeben wird:
		 *  - Sucht in Literatur und Autortabelle nach dem Auftreten
		 *    des übergebenen Textes in  Literatureinträgen und speichert
		 *    Nr, Titel, Autor, Verlag und ISBN als als Objekt im Feld
		 *    $Treffer. Sollte ein Fehler auftreten oder keine passenden
		 *    Einträge vorhanden sein, dann wird $Treffer ein Feld der
		 *    Länge 0.
		 *
		 *  Wenn $suchbegriff und $autor übergeben werden:
		 *  - Sucht in Literatur und Autortabelle nach dem Auftreten
		 *    von $autor in Autor und $suchbegriff im Titel des 
		 *    Literatureintrags und speichert Nr, Titel, Autor, Verlag
		 *    als als Objekt im Feld $Treffer. Sollte ein Fehler auftreten
		 *    und ISBN der Treffer oder keine passenden Einträge vorhanden
		 *    sein, dann wird $Treffer ein Feld der Länge 0.
		 *
		 *  \pre Datenbankverbindung muss bestehen.
		 *  \param[in] $autor String mit Autorname
		 *  \param[in] $suchbegriff String mit Literaturtitel bzw. wenn
		 *     einzeln übergeben Suchtext für Volltextsuche
		 */
		function Suche($suchbegriff="", $autor="")
		{
			switch (func_num_args())
			{
			case 0:
				$this->LetzteLiteratur();
				break;
			case 1:
				$this->VolltextSuche($suchbegriff);
				break;
			case 2:
				$this->AutorTitelSuche($autor, $suchbegriff);
				break;
			}
		}
	}
}
?>
