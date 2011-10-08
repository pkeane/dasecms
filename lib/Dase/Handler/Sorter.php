<?php

class Dase_Handler_Sorter extends Dase_Handler
{
		public $resource_map = array(
				'{id}' => 'sorter',
		);

		protected function setup($r)
		{
				$this->user = $r->getUser();
		}

		public function deleteSorter($r) 
		{
				$s = new Dase_DBO_Sorter($this->db);
				if ($s->load($r->get('id'))) {
						$s->delete();
						$s->renderResponse('sorter deleted');
				}
		}
}

