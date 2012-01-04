<?php

require_once 'Dase/DBO/Autogen/Attachment.php';

class Dase_DBO_Attachment extends Dase_DBO_Autogen_Attachment 
{
		public $node;

		//parent node
		public function getNode()
		{
				$node = new Dase_DBO_Node($this->db);
				if ($node->load($this->node_id)) {
						$this->node = $node;
				}
				return $this->node;
		}
}
