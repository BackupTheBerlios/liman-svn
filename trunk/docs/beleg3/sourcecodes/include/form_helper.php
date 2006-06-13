<?php
	/*! \brief Gibt HTML-Form-Input zurück
	 *
	 *  \param[in] $type Type des Inputfeldes
	 *  \param[in] $name ID und Name des Inputfeldes
	 *  \param[in] $value Inhalt des Feldes
	 *  \param[in] $failure ob Feld als fehlerhaft markiert werden soll
	 *  \return String mit HTML-Form-Input
	 */
	function form_input($type, $name, $value = "", $failure = false)
	{
		$str = "<input class=\"input_".$type."\" type=\"".htmlspecialchars($type)."\" name=\"".htmlspecialchars($name)."\" id=\"".htmlspecialchars($name)."\" ";

		if (empty($value) === false)
		{
			$str .= " value=\"".htmlspecialchars($value)."\" ";
		}

		if ($failure === true)
		{
			$str .= " class=\"input_failure\" ";
		}

		$str .= ">";
		
		return $str;
	}

	/*! \brief Gibt HTML-Form-Select zurück
	 *
	 *  \param[in] $options Feld mit Auswahlmöglichkeiten
	 *  \param[in] $name ID und Name der Auswahlfeldes
	 *  \param[in] $value aktuell ausgewähltes Element der Auswahl
	 *  \param[in] $failure ob Auswahl als fehlerhaft markiert werden soll
	 *  \return String mit HTML-Form-Select
	 */
	function form_select($options, $name, $value="", $failure = false)
	{
		$str = "<select id=\"".htmlspecialchars($name)."\" name=\"".htmlspecialchars($name)."\" ";
		if ($failure === true)
		{
			$str .= " class=\"input_failure\" ";
		}
		$str .= ">";

		foreach ($options as $option)
		{
			$str .= " <option ";
			if ($option == $value)
			{
				$str .= " selected ";
			}
			$str .= ">".htmlspecialchars($option)."</option>";
		}
		$str .= "</select>";

		return $str;
	}

	/*! \brief Gibt Formular mit Zurückknopf zurück
	 *
	 *  Erzeugt ein einfaches GET-Formular, dass nur aus einem Zurückbutton
	 *  besteht, der entweder auf eine Seite oder einer Seite mit ID
	 *  verweist. Die ID wird dabei einfach per verstecktem Feld
	 *  mit dem Namen id übergeben.
	 *  \param[in] $url Seite auf die der Knopf zeigt
	 *  \param[in] $id ID für aufzurufende Seite
	 *  \return String mit Zurück-Button im HTML-Form
	 */
	function form_back($url, $id="")
	{
		$str = "<form action=\"".htmlspecialchars($url)."\" method=\"get\"><span>";

		if (func_num_args() == 2)
		{
			$str .= form_input("hidden", "id", $id);
		}
		
		$str .= "<input type=\"submit\" value=\"Zurück\"></span></form>";

		return $str;
	}
?>