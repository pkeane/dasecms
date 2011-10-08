<?php

class Dase_Handler_Nodeset extends Dase_Handler
{
		public $resource_map = array(
				'list' => 'nodesets',
				'select_list' => 'select_list',
				'{id}' => 'nodeset',
				'{id}/nodes' => 'nodes',
				'{id}/filters' => 'nodeset_filters',
				'{id}/sorters' => 'nodeset_sorters',
		);

		private function _findNextUniqueAscii($ascii_id,$iter=0)
		{
				if (!$ascii_id) { return; }
				if ($iter) {
						$check = $ascii_id.'_'.$iter;
				} else {
						$check = $ascii_id;
				}
				$ns = new Dase_DBO_Nodeset($this->db);
				$ns->ascii_id = $check;
				if (!$ns->findOne()) {
						return $check;
				} else {
						$iter++;
						return $this->_findNextUniqueAscii($ascii_id,$iter);
				}

		}

		public function getSelectList($r) 
		{ 
				$output = '';
				$nodesets = new Dase_DBO_Nodeset($this->db);
				foreach ($nodesets->findAll(1) as $nodeset) {
						$output .= "<option value='$nodeset->id'>Nodeset: $nodeset->name</option>";
				}
				$r->renderResponse($output);
		}

		public function getNodeset($r) { 
				$id = $r->get('id'); 
				$ns = new Dase_DBO_Nodeset($this->db);
				$ns->load($id);
				$ns->getFilters();
				$ns->getSorters();
				$t = new Dase_Template($r);
				$atts = new Dase_DBO_Attribute($this->db);
				$atts->orderBy('name');
				$t->assign('atts', $atts->findAll(1));
				$t->assign('nodeset', $ns);
				$r->renderResponse($t->fetch('nodeset.tpl'));
		}

		public function getNodes($r) { 
				$id = $r->get('id'); 
				$ns = new Dase_DBO_Nodeset($this->db);
				$ns->load($id);
				$ns->getFilters();
				$ns->getSorters();
				$ns->retrieveNodes($r);
				$t = new Dase_Template($r);
				$t->assign('nodeset', $ns);
				$r->renderResponse($t->fetch('nodeset_nodes.tpl'));
		}

		public function getNodesets($r)
		{
				$t = new Dase_Template($r);
				$nodesets = new Dase_DBO_Nodeset($this->db);
				$nodesets->orderBy('name');
				$t->assign('nodesets',$nodesets->findAll(1));
				$r->renderResponse($t->fetch('nodesets.tpl'));
		}

		public function postToNodesets($r)
		{
				$ns = new Dase_DBO_Nodeset($this->db);
				$ns->name = $r->get('name');
				$ns->max = $r->get('max');
				$ns->description = $r->get('description');
				$ns->cache = '';
				$ns->ascii_id = $this->_findNextUniqueAscii(Dase_Util::dirify($ns->name));
				$ns->insert();
				$r->renderRedirect('nodeset/list');
		}

		public function postToNodesetFilters($r) 
		{ 
				$id = $r->get('id'); 
				$ns = new Dase_DBO_Nodeset($this->db);
				$ns = $ns->load($id);
				if (!$ns) { 
						$r->renderError(404); 
				}
				$filter = new Dase_DBO_Filter($this->db);
				$filter->att_ascii = $r->get('att_ascii');
				$filter->operator = $r->get('operator');
				if ('gt' == $filter->operator) {
						$filter->operator = '>';
				}
				if ('lt' == $filter->operator) {
						$filter->operator = '<';
				}
				$filter->value = $r->get('value');
				$filter->nodeset_id = $ns->id;
				$filter->insert();
				$r->renderRedirect('nodeset/'.$ns->id);

		}

		public function postToNodesetSorters($r) { 
				$id = $r->get('id'); 
				$ns = new Dase_DBO_Nodeset($this->db);
				$ns = $ns->load($id);
				if (!$ns) { 
						$r->renderError(404); 
				}
				$sorter = new Dase_DBO_Sorter($this->db);
				$sorter->att_ascii = $r->get('att_ascii');
				$sorter->is_descending = $r->get('is_descending');
				$sorter->nodeset_id = $ns->id;
				$sorter->insert();
				$r->renderRedirect('nodeset/'.$ns->id);
		}
}
