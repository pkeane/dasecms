<?php

class Dase_Handler_Attribute extends Dase_Handler
{
		public $resource_map = array(
				'{ascii_id}/defined' => 'defined_values',
		);

		protected function setup($r)
		{
				$this->user = $r->getUser();
		}

		public function getDefinedValues($r) 
		{
				$att = new Dase_DBO_Attribute($this->db);
				$att->ascii_id = $r->get('ascii_id');
				$att->findOne();
				$output = '<option value="">select one:</option>';
				$i = 0;
				foreach ($att->defined as $dv) {
						$output .= "<option value='$dv'>$dv</option>";
						$i++;
				}
				if (!$i) {
						$r->renderResponse('');
				}
				$r->renderResponse($output);
		}
}

