<?php

	if (!defined("global"))
	{
		define("global", 1);
		
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

		require($basepath."include/config.php");
	}
?>