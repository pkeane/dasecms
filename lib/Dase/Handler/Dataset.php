<?php

class Dase_Handler_Dataset extends Dase_Handler
{
		public $resource_map = array(
				'{id}' => 'dataset',
		);

		protected function setup($r)
		{
				$this->user = $r->getUser();
		}

		public function postToDataset($r) 
		{
				$ds = new Dase_DBO_DataSet($this->db);
				if ($ds->load($r->get('id'))) {
						if ($this->user->eid != $ds->created_by) {
								$r->renderError(401);
						}
						$pd = new Dase_DBO_PersonData($this->db);
						$pd->data_set_id = $ds->id;
						$pd->foot_length = $r->get('foot_length');
						$pd->age = $r->get('age');
						$pd->gender = $r->get('gender');
						$pd->stride_length = $r->get('stride_length');
						$pd->height = $r->get('height');
						$pd->created_by = $this->user->eid;
						$pd->created = date(DATE_ATOM);
						$pd->insert();
				}
				$r->renderRedirect('page/trackways/data_set/'.$ds->id);
		}
}

