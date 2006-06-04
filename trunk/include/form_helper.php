<?php
	/*! \brief Gibt HTML-Form-Input zurück
	 *
	 *  \param[in] $type Type des Inputfeldes
	 *  \param[in] $name ID und Name des Inputfeldes
	 *  \param[in] $value Inhalt des Feldes
	 *  \param[in] $failure ob Feld als fehlerhaft markiert werden soll
	 */
	function form_input($type, $name, $value = "", $failure = false)
	{
		$str = "<input type=\"".htmlspecialchars($type)."\" name=\"".htmlspecialchars($name)."\" id=\"".htmlspecialchars($name)."\" ";

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
?>