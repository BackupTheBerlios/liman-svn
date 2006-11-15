<?php
	class ErrorMessage
	{
		var $Unit = false;
		var $Test = false;
		var $Message;
		var $Expected;
		var $Actual;
		
		function ErrorMessage( $unit, $test, $message, $expected, $actual )
		{
			if( $unit != null )
				$this->Unit = $unit;
			if( $test != null )
				$this->Test = $test;
			$this->Message = $message;
			$this->Expected = $expected;
			$this->Actual = $actual; 
		}
		
		function ToString()
		{
			$testcase = "";
			if( $this->Test !== false )
			{
				if( $this->Unit !== false )
				{
					$testcase = " von ".$this->Unit.".".$this->Test;
				}
				else
				{
					$testcase = " von ".$this->Test;
				}
			}
			
			$values = "";
			if( $this->Actual != $this->Expected )
				$values = " - Erwartet: <".$this->Expected."> Ist: <".$this->Actual.">";
			
			return "Test".$testcase." Fehlgeschlagen. Grund: ".$this->Message.$values;
		}
	}
?>
