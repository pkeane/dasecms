<?php

class Dase_Handler_Attachment extends Dase_Handler
{
		public $resource_map = array(
				'{id}' => 'attachment',
		);

		protected function setup($r)
		{
				$this->user = $r->getUser();
		}

		public function deleteAttachment($r) 
		{
				$at = new Dase_DBO_Attachment($this->db);
				if (!$at->load($r->get('id'))) {
						$r->renderError(404);
				}
				$node = $at->getNode();
				if (($this->user->eid != $node->created_by) || !$this->user->is_admin) {
						$r->renderError(401);
				}
				if ($at->load($r->get('id'))) {
						$at->delete();
						$r->renderResponse('attachment deleted');
				}
		}
}

