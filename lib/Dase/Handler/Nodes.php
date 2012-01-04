<?php

class Dase_Handler_Nodes extends Dase_Handler
{
		public $resource_map = array(
				'/' => 'nodes',
		);

		protected function setup($r)
		{
				$this->user = $r->getUser();
		}

		public function getNodes($r) 
		{
				$t = new Dase_Template($r);
				$nodes = new Dase_DBO_Node($this->db);
				$nodes->orderBy('updated DESC');
				$all_nodes = array();
				$pages = array();
				foreach ($nodes->findAll(1) as $n) {
						$all_nodes[] = $n;
						if ($n->alias) {
								$pages[] = "page/$n->alias";
						}
				}
				$t->assign('nodes',$all_nodes);
				$t->assign('pages',$pages);
				$r->renderResponse($t->fetch('nodes.tpl'));
		}
}

