<?php

class Dase_Handler_Datasets extends Dase_Handler
{
		public $resource_map = array(
				'{eid}' => 'datasets',
		);

		protected function setup($r)
		{
				$this->user = $r->getUser();
		}

		public function postToDatasets($r) 
		{
				if ($r->get('eid') == $this->user->eid && $r->get('name')) { 
						$ds = new Dase_DBO_DataSet($this->db);
						$ds->name = $r->get('name');
						$ds->created = date(DATE_ATOM);
						$ds->created_by = $this->user->eid;
						$ds->insert();
						$r->renderRedirect('page/trackways/add_data');
				} else {
						$r->renderError(400);
				}
		}
}

