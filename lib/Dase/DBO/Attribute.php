<?php

require_once 'Dase/DBO/Autogen/Attribute.php';

class Dase_DBO_Attribute extends Dase_DBO_Autogen_Attribute 
{
		public function __get($key)
		{
				if ('defined' == $key) {
						if ($this->defined_values) {
								return Dase_Json::toPhp($this->defined_values);
						} else {
								return array();
						}
				}
				return parent::__get($key);
		}
}
