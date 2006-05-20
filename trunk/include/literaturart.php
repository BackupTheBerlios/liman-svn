<?php
if(!defined("LiteraturArt"))
{
	define("LiteraturArt", 1);

	/*! \brief TODO
	 *
	 *  TODO
	 *  \pre
	 */
	class LiteraturArt
	{
		/*! Typ des Buches
		 *   - 1 Buch
		 *   - 2 Artikel
		 *   - 3 Broschüre
		 *   - 4 Protokoll
		 *   - 5 Anleitung
		 *   - 6 Diplomarbeit
		 *   - 7 Dissertation
		 *   - 8 Techn. Bericht
		 *   - 9 Unveröffentlicht
		 *   - sonst Sonstiges
		 *  \private
		 */
		var $value = 0;
		
		/*! \brief TODO
		 *
		 *  TODO
		 *  \pre
		 *  \param[in] $text TODO
		 */
		function LiteraturArt($text)
		{
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

			case "Broschüre":
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
			case "mastersthesis":
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

			case "Unveröffentlicht":
			case "unpublished":
				$this->value = 9;
				break;

			default:
			case "Sonstiges":
			case "misc":
				$this->value = 0;
			};
		}
		
		/*! \brief TODO
		 *
		 *  TODO
		 *  \pre
		 *  \return TODO
		 */
		function GetDisplayText()
		{
			switch ($this->value)
			{
			case 1:
				return "Buch";

			case 2:
				return "Artikel";

			case 3:
				return "Broschüre";
		
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
				return "Unveröffentlicht";

			default:
			case 0:
				return "Sonstiges";
			};
		}
		
		/*! \brief TODO
		 *
		 *  TODO
		 *  \pre
		 *  \return TODO
		 */
		function GetBibtexText()
		{
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
				return "mastersthesis";

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
}
?>
