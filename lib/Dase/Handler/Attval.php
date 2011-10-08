<?php

class Dase_Handler_Attval extends Dase_Handler
{
		public $resource_map = array(
				'{id}' => 'attval',
		);

		protected function setup($r)
		{
				$this->user = $r->getUser();
		}

		public function deleteAttval($r) 
		{
				$av = new Dase_DBO_Attval($this->db);
				if ($av->load($r->get('id'))) {
						$av->delete();
						$r->renderResponse('attval deleted');
				}
		}
}

