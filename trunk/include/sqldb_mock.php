<?php
	class SQLDB_Mock
	{
		var $query_result = false; ///< Identifikation der letzten Datenbankabfrage
		var $fetch_index = 0;
		var $isOpen = false;
		
		function SQLDB_Mock()
		{
			$this->isOpen = true;
		}
		
		function Close()
		{
			$this->isOpen = false;
		}
		
		function DataSeek($row_number)
		{
			if( $this->isOpen && is_array($this->query_result) && ($row_number < count($this->query_result)) )
			{
				return $this->query_result[$this->fetch_index];
			}
			else
			{
				return false;
			}
		}
		
		function Fetch()
		{
			if( $this->isOpen && is_array($this->query_result) && ( $this->fetch_index < count($this->query_result) ) )
			{
				return $this->query_result[$this->fetch_index++];
			}
			else
			{
				return false;
			}
		}
		
		function FreeResult()
		{
			if ($this->query_result !== false)
			{
				$this->query_result = false;
				$this->fetch_index = 0;
			}
			
			return true;
		}
		
		function GetAffectedRows()
		{
			if ($this->isOpen)
			{
				if($this->query_result === false )
				{
					return 0;
				}
				
				if( is_int( $this->query_result ) )
				{
					return $this->query_result;
				}
				
				if( is_array($this->query_result) )
				{
					return count($this->query_result);
				}
				
				return false;
			}
			else
			{
				return false;
			}
		}
		
		function GetError()
		{
			$error = array();

			// was könnte hier rein?

			return $error;
		}
		
		function GetNumRows()
		{
			if ($this->db_id !== false && is_array($this->query_result) )
			{
				return count($this->query_result);
			}
			else
			{
				return false;
			}
		}
		
		var $error_msgs = array();
		var $patterns = array();
		var $results = array();
		var $queryCounter = 0;
		
		/*! \brief 
		 *
		 *  TODO
		 *  \pre -
		 *  \param[in] $pattern Regulärer Ausdruck mit dem die Query verglichen wird
		 *  \param[in] $result Ergebnis der Abfrage
		 *  \remarks
		 *  Der Reguläre Ausdruck dient nur der Identifikation der Query, nicht der zur Verifikation.
		 *  Die Query muss seperat auf ihre Funktion getestet werden.
		 * 
		 *  Wird als Ergebnis ein Integer angegeben, wird das als Zahl der betroffenen Zeilen interpretiert.
		 *  Wird als Ergebnis ein Array angegeben, so wird es als mehrzeiliges Ergebnis gewertet.
		 */
		function ExpectQuery( $pattern, $result )
		{
			if( !is_int($result) && !is_array($result) )
			{
				$buff = $result;
				$result = array();
				$result[] = $buff;
			}
			
			$this->patterns[] = $pattern;
			$this->results[] = $result;
		}
		
		function Verify()
		{
			if( $this->queryCounter != count($this->results) )
			{
				$this->error_msgs[] = "Nicht alle Queries wurden ausgeführt - erwartet: ".count($this->results)." tatsächlich: ".$this->queryCounter;
			}
			
			$ret = $this->error_msgs;
			
			// reset
			$this->error_msgs = array();
			$this->patterns = array();
			$this->results = array();
			$this->queryCounter = 0;
			
			if( count($ret) == 0)
			{
				return true;
			}
			else
			{
				return $ret;
			}
		}
		
		function Query($query)
		{
			if( $this->isOpen )
			{
				if( count($this->patterns) <= $this->queryCounter )
				{
					$this->queryCounter++;
					$this->error_msgs[] = "Unerwartete Anzahl an Queries - erwartet ".count($this->patterns)." tatsächlich: ".$this->queryCounter;
					return false;
				}
				else if( !preg_match($this->patterns[$this->queryCounter],$query) )
				{
					$this->error_msgs[] = "Unerwartete Query - erwartet: ".$this->patterns[$this->queryCounter]." tatsächlich: ".$query;
					return false;
				}
				
				$this->FreeResult();
				$this->query_result = $this->results[$this->queryCounter++];
				return true;
			}
			else
			{
				return false;
			}
		}
	}
?>
