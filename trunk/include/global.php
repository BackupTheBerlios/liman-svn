<?php
	if (empty($basepath))
	{
		$basepath = "./";
	}

	// Benutze Backslashes, wenn dies nicht automatisch gemacht wird
	if( !get_magic_quotes_gpc())
	{
		function quote_array(&$array)
		{
			if (is_array($array))
			{
				while (list($k, $v) = each($array))
				{
					if (is_array($array[$k]))
					{
						while (list($k2, $v2) = each($array[$k]))
						{
							$array[$k][$k2] = addslashes($v2);
						}
						@reset($array[$k]);
					}
					else
					{
						$array[$k] = addslashes($v);
					}
				}
				@reset($array);
			}
		}
	
		//quote_array($HTTP_GET_VARS);
		quote_array($_GET);
		//quote_array($HTTP_POST_VARS);
		quote_array($_POST);
		//quote_array($HTTP_COOKIE_VARS);
		quote_array($_COOKIE);
	}

	/*! \brief Wandelt String in HTML-ID um
	 *
	 *  \param[in] str zu verarbeitende Rohdaten
	 *  \return umgewandelter String
	 */
	function makeid($str)
	{
		$str = strtolower($str);
		$str = str_replace(" ", "_", $str);
		$str = str_replace("/", "_", $str);
		$str = str_replace("\\", "_", $str);

		$str = str_replace("\"", "_", $str);
		$str = str_replace("'", "_", $str);

		$str = str_replace("ü", "ue", $str);
		$str = str_replace("&uuml;", "ue", $str);

		$str = str_replace("ä", "ae", $str);
		$str = str_replace("&auml;", "ae", $str);

		$str = str_replace("ö", "oe", $str);
		$str = str_replace("&ouml;", "oe", $str);

		if ($str[0] == '_')
		{
			$str[0] = " ";
		}
		return $str;
	}

	require_once($basepath."include/config.php");
	require_once($basepath."include/sqldb.php");
	require_once($basepath."include/login.php");
?>