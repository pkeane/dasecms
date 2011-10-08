<?php

function sortByNum($a,$b)
{
		if ($a['num'] == $b['num']) {
				return 0;
		}
		return ($a['num'] < $b['num']) ? -1 : 1;
}

class Dase_Handler_Page extends Dase_Handler
{
		public $resource_map = array(
				'{seg1}' => 'node',
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
				$t = new Dase_Template($r);
				$node = new Dase_DBO_Node($this->db);
				$alias = $this->_getUri($r);
				$node->alias = $alias;
				$node = $node->findOne();
				if (!$node) {
						$this->getDynamicPage($r,$alias);
						$r->renderError(404);
				}
				$t->assign('node',$node);
				if ('image' == substr($node->mime,0,5)) {
						$t->assign('is_image',1);
				}
				$template_file = 'pages/page-'.$node->alias.'.tpl';
				if ($t->template_exists($template_file)) {
						$r->renderResponse($t->fetch($template_file));
				} else {
						$r->renderResponse($t->fetch('page.tpl'));
				}   
		}

		public function getDynamicPage($r,$uri_path)
		{
				$nodes = new Dase_DBO_Node($this->db);
				$nodes->addWhere('dynamic_alias','','>');
				$matches = array();
				$routes = array();
				foreach ($nodes->findAll(1) as $n) {
						$num = preg_match_all("/{([\w]*)}/",$n->dynamic_alias,$matches);
						if ($num) {
								$route = array();
								$uri_regex = preg_replace("/{[\w]*}/","([\w-,.]*)",$n->dynamic_alias);
								$route['num'] = $num;
								$route['matches'] = $matches[1];
								$route['uri_regex'] = $uri_regex;
								$route['node'] = $n;
								$routes[] = $route;
						}
						//sort so fewer dynamic segments come first
						usort($routes,'sortByNum');
				}
				$matched_node = null;
				foreach ($routes as $route) {
						$uri_matches = array();
						$uri_regex = $route['uri_regex'];
						if (preg_match("!^$uri_regex\$!",$uri_path,$uri_matches)) {
								$matched_node = $route['node'];
								array_shift($uri_matches);
								$params = array_combine($route['matches'],$uri_matches);
								$r->setParams($params);
								break;
						}
				}
				if (!$matched_node) {
						$r->renderError(404);
				}
				$t = new Dase_Template($r);
				$t->assign('node',$matched_node->asPhp($r));
				$template_file = 'pages/page-'.$matched_node->alias.'.tpl';
				if ($t->template_exists($template_file)) {
						$r->renderResponse($t->fetch($template_file));
				} else {
						$r->renderResponse($t->fetch('page.tpl'));
				}   
		}
}
