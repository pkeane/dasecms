<?php

//stdClass wrapper excude to use __get
class Dase_Node  
{
		public $fields = array();
		public $meta = array();
		public $attachments = array();


		public function __construct(Dase_DBO_Node $dbo_node)
		{
			foreach ($dbo_node->asArray() as $k => $v) {
					$this->fields[$k] = $v;
			}
			$this->id = $dbo_node->id;
		}

		public function __get($key)
		{
				if (isset($this->meta[$key]) && isset($this->meta[$key][0])) {
						return $this->meta[$key][0];
				}
				if ('is_image' == $key) {
						if ('image' == substr($this->mime,0,5)) {
								return true;
						} else {
								return false;
						}
				}
				if ( array_key_exists( $key, $this->fields ) ) {
						return $this->fields[ $key ];
				}
		}
}
