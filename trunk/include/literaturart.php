<?php
	if(!defined("LiteraturArt"))
	{
		define("LiteraturArt", 1);

		/*! \brief TODO
		 *
		 *  TODO
		 */
		class LiteraturArt
		{
			var $value = 0; ///< TODO
			
			/*! \brief TODO
			 *
			 *  TODO
			 *  \param $text TODO
			 */
			function LiteraturArt($text)
			{
				switch ($text)
				{
				case "book":
				case "inbook":
				case "Buch":
					$this->value = 0;
					break;

				case "Artikel":
				case "article":
					$this->value = 1;
					break;

				case "Broschüre":
				case "booklet":
					$this->value = 2;
					break;
			
				case "Protokoll":
				case "proceedings":
				case "inproceedings":
				case "conference":
					$this->value = 3;
					break;

				case "Anleitung":
				case "manual":
					$this->value = 4;
					break;

				case "Diplomarbeit":
				case "mastersthesis":
					$this->value = 5;
					break;

				case "Dissertation":
				case "phdthesis":
					$this->value = 6;
					break;

				case "Techn. Bericht":
				case "techreport":
					$this->value = 7;
					break;

				case "Unveröffentlicht":
				case "unpublished":
					$this->value = 8;
					break;

				default:
				case "Sonstiges":
				case "misc":
					$this->value = 9;
				};
			}
			
			/*! \brief TODO
			 *
			 *  TODO
			 *  \return TODO
			 */
			function GetDisplayText()
			{
				switch ($this->value)
				{
				case 0:
					return "Buch";

				case 1:
					return "Artikel";

				case 2:
					return "Broschüre";
			
				case 3:
					return "Protokoll";

				case 4:
					return "Anleitung";

				case 5:
					return "Diplomarbeit";

				case 6:
					return "Dissertation";

				case 7:
					return "Techn. Bericht";

				case 8:
					return "Unveröffentlicht";

				default:
				case 9:
					return "Sonstiges";
				};
			}
			
			/*! \brief TODO
			 *
			 *  TODO
			 *  \return TODO
			 */
			function GetBibtexText()
			{
				switch ($this->value)
				{
				case 0:
					return "book";

				case 1:
					return "article";

				case 2:
					return "booklet";
			
				case 3:
					return "proceedings";

				case 4:
					return "manual";

				case 5:
					return "mastersthesis";

				case 6:
					return "phdthesis";

				case 7:
					return "techreport";

				case 8:
					return "unpublished";

				default:
				case 9:
					return "misc";
				};
			}
		}
	}
?>
