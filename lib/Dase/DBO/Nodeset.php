<?php

require_once 'Dase/DBO/Autogen/Nodeset.php';

class Dase_DBO_Nodeset extends Dase_DBO_Autogen_Nodeset 
{
		public $parent_node;
		public $filters;
		public $sorters;
		public $dynamic_values;
		public $sorted_nodes;

		public function getNode()
		{
				if ($this->node) {
						return $node;
				}
				$node = new Dase_DBO_Node($this->db);
				$node->load($this->node_id);
				$this->node = $node;
				return $node;
		}

		public function getFilters()
		{
				if ($this->filters) {
						return $this->filters;
				}
				$filters = new Dase_DBO_Filter($this->db);
				$filters->nodeset_id = $this->id;
				$filters->orderBy('sort_order');
				$set = array();
				foreach ($filters->findAll(1) as $f) {
						$dv = $f->getDynamicValue();
						if ($dv) {
								$this->dynamic_values[$dv] = 1;
						}
						$set[] = $f;
				}
				$this->filters = $set;
				return $this->filters;
		}

		public function getSorters()
		{
				if ($this->sorters) {
						return $this->sorters;
				}
				$sorters = new Dase_DBO_Sorter($this->db);
				$sorters->nodeset_id = $this->id;
				$sorters->orderBy('sort_order');
				$this->sorters = $sorters->findAll(1);
				return $this->sorters;
		}

		public function asJson($r) 
		{
				return Dase_Json::get($this->asPhp($r));
		}

		public function asPhp($r)
		{
				$set = array();
				foreach ($this->retrieveNodes($r) as $node) {
						$phpnode = $node->asPhp($r,false);
						$set[] = $phpnode;
				}
				return $set;
		}

		public function retrieveNodes($r)
		{
				$node_id_array = array();
				$nodes = new Dase_DBO_Node($this->db);
				$poison_node_id_array = array();

				//cannot declare av_node_id_array here
				//since we need to know if a filter eliminates
				//every node

				$filters = $this->getFilters();
				foreach ($filters as $filter) {
						if ('{' == substr($filter->value,0,1) && '}' == substr($filter->value,-1)) {
								//will get value from GET param
								$value = $r->get(trim($filter->value,'{}'));
						} else {
								$value = $filter->value;
						}
						if ('omit_if' == $filter->operator) {
								if ('_' == substr($filter->att_ascii,0,1)) {
										$poison_nodes = new Dase_DBO_Node($this->db);
										$pfield = substr($filter->att_ascii,1);
										$poison_nodes->$pfield = $value;
										foreach ($poison_nodes->findAll(1) as $pn) {
												$poison_node_id_array[] = $pn->id;
										}
								} else {
										$pattvals = new Dase_DBO_Attval($this->db);
										$pattvals->att_ascii = $filter->att_ascii;
										$pattvals->value = $value;
										foreach ($pattvals->findAll(1) as $pav) {
												$poison_node_id_array[] = $pav->node_id;
										}
								}
						} else {
								//everything OTHER than omit_if
								if ('_' == substr($filter->att_ascii,0,1)) {
										$field = substr($filter->att_ascii,1);
										if ('exists' == $filter->operator) {
												$nodes->addWhere($field,'','>');
										} else {
												$nodes->addWhere($field,$value,$filter->operator);
										}
								} else {
										$attvals = new Dase_DBO_Attval($this->db);
										$attvals->att_ascii = $filter->att_ascii;
										if ('exists' == $filter->operator) {
												$attvals->addWhere('value','','>');
										} else {
												$attvals->addWhere('value',$value,$filter->operator);
										}
										$node_ids = array();
										foreach ($attvals->findAll(1) as $av) {
												$node_ids[] = $av->node_id;
										}
										if (!isset($av_node_id_array)) {
												$av_node_id_array = $node_ids;
										} else {
												$av_node_id_array = array_intersect($av_node_id_array,$node_ids);
										}
								}
						}
				}
				foreach ($nodes->findAll(1) as $found_node) {
						$node_id_array[] = $found_node->id;
				}
				if (isset($av_node_id_array)) {
						$node_id_array = array_intersect($node_id_array,$av_node_id_array);
				}  

				if (count($poison_node_id_array)) {
						$node_id_array = array_diff($node_id_array,$poison_node_id_array);
				}

				$fields = array();
				$sorters = $this->getSorters();
				foreach ($sorters as $sorter) {
						$fields[$sorter->att_ascii] = $sorter->is_descending;
				}
				$node_set = array();
				foreach (Dase_DBO_Node::getByIds($this->db,$node_id_array) as $n) {
						$n->getAttvals();
						$node_set[] = $n;
				}
				$this->sorted_nodes = Dase_DBO_Node::nodeMultiSort($node_set,$fields);
				return $this->sorted_nodes;
		}
}
