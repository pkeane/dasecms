<?php

require_once 'Dase/DBO/Autogen/Filter.php';

class Dase_DBO_Filter extends Dase_DBO_Autogen_Filter 
{
		public $dynamic_value;

		public function getDynamicValue()
		{
				if ('{' == substr($this->value,0,1) && '}' == substr($this->value,-1)) {
						$this->dynamic_value = trim($this->value,'{}');
						return $this->dynamic_value;
				} else {
						return false;
				}
		}
}
