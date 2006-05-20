<?php
	/*! \brief Gib §string bis zum ersten Auftreten von $needle aus
	 *
	 *  TODO
	 *  \pre
	 *  \param[in] $string zu lesende String
	 *  \param[in] $needle zu findende String
	 *  \param[in] $offset Offset des als erstes zu bearbeidende Buchstabens
	 *  \return Array aus Position des Fundes und Teilstring bis (aber nicht einschließlich) gefundenem $needle
	 *  \remarks Gibt boolean false zurück, wenn needle nicht gefunden werden kann
	 */
	function strtill($string, $needle , $offset = 0)
	{
		if (($pos = strpos($string, $needle, $offset)) !== false)
		{
			return array($pos, substr($string, $offset, $pos-$offset));
		}
		else
		{
			return false;
		}
	}

	/*! \brief BibTeX Parser und Exporter
	 *
	 *  TODO
	 *  \pre
	 *  \note Das sollte mit Buch verschmolzen werden
	 */
	class BibTeX
	{
		var $type; ///< Typ der Literatur
		var $id; ///< Buchidentifikationsnummer
		var $title; ///< Titel der Literatur
		var $author; ///< Autoren der Literatur
		var $year; ///< Erscheinungsjahr
		var $publisher; ///< Verlag/Herausgeber
		var $isbn; ///< ISBN der Literatur
		var $annote; ///< Bemerkung zur Literatur
		
		
		/*! \brief Konstruktor
		 * 
		 *  Erstellt eine leere Literaturangabe
		 *  \pre
		 */
		function BibTeX()
		{
			$type = "book";
			$id = "";
			$title = "";
			$author = "";
			$year = "";
			$publisher = "";
			$isbn = "";
			$annote = "";
		}

		/*! \brief Parser für BibTeX
		 *
		 *  TODO
		 *  \pre
		 *  \param[in] $string Zu "parsende" String
		 *  \return Array von BibTeX
		 *  \remarks $string wird nicht exakt auf Fehler untersucht und gegebenenfalls versuchen zu ignorieren
		 *  \remarks Gibt boolean false zurück, wenn nichts gefunden werden kann
		 */
		function parse($string)
		{
			$allowed_entries = array('book', 'article', 'booklet',
					'conference', 'inbook', 'incollection', 'inproceedings', 'manual',
					'mastersthesis', 'misc', 'phdthesis', 'proceedings', 'techreport',
					'unpublished');
			$allowed_fields = array('author', 'title', 'publisher', 'year', 'ISBN');

			// Funktioniert nicht bei Argumenten über mehrere Zeilen
			if (preg_match_all('/@[\w]+[\s]*\{[\s]*[-\d\w]+([\s]*,[\s]*[\w]*[\s]*=[\s]*([\w]+|\{.*\}|".*")[\s]*)+\}/', $string, $regexp_entries) !== false)
			{
				$num_entries = sizeof($regexp_entries[0]);
			}
			else
			{
				$num_entries = 0;
			}

			$entries = false;
			$curpos = 0;
			
			for ($i = 0; $i < $num_entries; $i++)
			{
				$cur = new BibTeX;
				$curpos = 1; // ohne @ lesen
				// Lese Typ vom Eintrag
				if (($substr = strtill($regexp_entries[0][$i], '{', $curpos)) !== false)
				{
					$cur->type = strtolower(trim($substr[1]));
					$curpos = $substr[0]+1;
				}
				else
				{
					break; // Fehler beim Lesen -> Abbruch
				}

				
				// Haben wir überhaupt den Anfang eines Eintrags gefunden?
				if (in_array($cur->type, $allowed_entries) === false)
				{
					continue;
				}
				

				// Lese Kürzel
				if (($substr = strtill($regexp_entries[0][$i], ',', $curpos)) !== false)
				{
					$cur->id = trim($substr[1]);
					$curpos = $substr[0]+1;
				}
				else
				{
					continue; // Fehler beim Lesen -> Abbruch
				}

				// Extrahiere "Optionen"
				if (preg_match_all('/([\w]*[\s]*=[\s]*([\w]+|\{.*\}|".*")[\s]*(,|\}))+/', $regexp_entries[0][$i], $regexp_options) !== false)
				{
					$num_options = sizeof($regexp_options[0]);
					for ($j = 0; $j < $num_options; $j++)
					{
						// Name der "Option" auslesen
						$option = strtill($regexp_options[0][$j], "=");
						
						// Name des Arguments der "Option" auslesen und bereinigen
						$argument = substr($regexp_options[0][$j], $option[0]+1, strlen($regexp_options[0][$j])-$option[0]-2);
						$argument = trim($argument);

						if ($argument[0] == "{" && $argument[strlen($argument)-1] == "}")
						{
							$argument = substr($argument, 1, strlen($argument)-2);
						}
						if ($argument[0] == "\"" && $argument[strlen($argument)-1] == "\"")
						{
							$argument = substr($argument, 1, strlen($argument)-2);
						}

						switch (strtolower(trim($option[1])))
						{
						case "title":
							$cur->title = $argument;
							break;
						case "author":
							$cur->author = $argument;
							break;
						case "year":
							$cur->year = $argument;
							break;
						case "publisher":
							$cur->publisher = $argument;
							break;
						case "isbn":
							$cur->isbn = $argument;
							break;
						case "annote":
							$cur->annote = $argument;
							break;
						}
					}
				}
				else
				{
					continue;
				}
				
				// Erzeuge array, wenn noch nicht geschehen
				if ($entries === false)
				{
					$entries = array();
				}
				$entries[] = $cur;
			}

			return $entries;
		}

		/*! \brief Konvertiert BibTeX-Eintrag in String
		 *
		 *  TODO
		 *  \pre
		 *  \return String mit BibTeX-Informationen
		 *  \remarks Gibt boolean false zurück, wenn zu wenig Informationen vorhanden sind
		 */
		function toString()
		{
			if (!empty($this->type) && !empty($this->id))
			{
				$str = "@".$this->type."{".$this->id;
				
				if (!empty($this->title))
					$str .= ",\n\ttitle = \"".$this->title."\"";
				if (!empty($this->author))
					$str .= ",\n\tauthor = \"".$this->author."\"";
				if (!empty($this->year))
					$str .= ",\n\tyear = \"".$this->year."\"";
				if (!empty($this->publisher))
					$str .= ",\n\tpublisher = \"".$this->publisher."\"";
				if (!empty($this->isbn))
					$str .= ",\n\tisbn = \"".$this->isbn."\"";
				if (!empty($this->annote))
					$str .= ",\n\tannote = \"".$this->$annote."\"";
				
				$str .= "\n}\n";
				return $str;
			}
			else
				return false;
			
		}
	}
?>
