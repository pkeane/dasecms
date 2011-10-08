<?php

class Dase_Handler_File extends Dase_Handler
{
		public $resource_map = array(
				'{seg1}' => 'node',
				'{id}/thumb' => 'node_thumbnail',
				'{seg1}/{seg2}' => 'node',
				'{seg1}/{seg2}/{seg3}' => 'node',
				'{seg1}/{seg2}/{seg3}/{seg4}' => 'node',
				'{seg1}/{seg2}/{seg3}/{seg4}/{seg5}' => 'node',
		);

		private function _getUri($r)
		{
				if ($r->has('uri')) {
						return $r->get('uri');
				}
				$uri_parts = array();
				foreach (array(1,2,3,4,5) as $i)  {
						if ($r->has('seg'.(string) $i)) {
								$uri_parts[] = $r->get('seg'.(string) $i);
						}       
				}
				return join('/',$uri_parts);
		} 

		public function getNode($r) { 
				$node = new Dase_DBO_Node($this->db);
				$alias = $this->_getUri($r);
				if (is_numeric($alias)) {
						$node = $node->load($alias);
				} else {
						$node->alias = $alias;
						$node = $node->findOne();
				}
				if (!$node) {
						$r->renderError(404);
				}
				if (!$node->filepath) {
						if ($node->body) {
								$r->renderResponse($node->body);
						}
						if ($node->title) {
								$r->renderResponse($node->title);
						}
						$r->renderResponse($node->name);
				}
				$r->serveFile($node->filepath,$node->mime);
		}

		public function getNodeThumbnail($r) { 
				$node = new Dase_DBO_Node($this->db);
				$node = $node->load($r->get('id'));
				if (!$node) {
						$r->renderError(404);
				}
				$r->serveFile($node->thumbnail_path,'image/jpeg');
		}
}
