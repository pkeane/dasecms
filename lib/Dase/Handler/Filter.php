<?php

class Dase_Handler_Filter extends Dase_Handler
{
		public $resource_map = array(
				'{id}' => 'filter',
		);

		protected function setup($r)
		{
				$this->user = $r->getUser();
		}

		public function deleteFilter($r) 
		{
				$f = new Dase_DBO_Filter($this->db);
				if ($f->load($r->get('id'))) {
						$f->delete();
						$r->renderResponse('filter deleted');
				}
		}
}

