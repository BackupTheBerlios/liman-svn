<?php
	require_once("include/tests/errormessage.php");
	
	class SQLDB_Mock
	{
		var $query_result = false;
		var $fetch_index = 0;
		var $isOpen = false;
		var $error_msg = false;
		
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

		function GetInsertID()
		{
			if ($this->isOpen)
			{
				return rand();
			}
			else
			{
				return false;
			}
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
		
		var $error = false;
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
			if( !is_int($result) && !is_array($result) && ($result !== false) )
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
			$ret = $this->error;
			if( ($ret === false) && (count($this->results) != $this->queryCounter) )
			{
				$ret = new ErrorMessage( null, null, "Anzahl Queries", count($this->results), $this->queryCounter );
			}
			else
			{
				$ret = true;
			}
			
			// reset
			$this->error = false;
			$this->error_msg = false;
			$this->patterns = array();
			$this->results = array();
			$this->queryCounter = 0;
			
			return $ret;
		}
		
		function Query($query)
		{
			if( $this->isOpen && ($this->error_msg === false) )
			{
				if( count($this->patterns) <= $this->queryCounter )
				{
					$this->queryCounter++;
					$this->error = new ErrorMessage( null, null, "Anzahl an Queries", count($this->patterns), $this->queryCounter );
					return false;
				}
				elseif( preg_match("/".$this->patterns[$this->queryCounter]."/",$query) === false)
				{
					$this->error = new ErrorMessage( null, null, "Unerwartete Query", $this->patterns[$this->queryCounter], $query );
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
