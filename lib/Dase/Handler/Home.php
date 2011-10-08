<?php

class Dase_Handler_Home extends Dase_Handler
{
	public $resource_map = array(
		'/' => 'home',
	);

	protected function setup($r)
	{
		$this->user = $r->getUser();
	}

	public function getHome($r) 
	{
		$t = new Dase_Template($r);
		$nodes = new Dase_DBO_Node($this->db);
		$t->assign('nodes',$nodes->findAll(1));
		$r->renderResponse($t->fetch('home.tpl'));
	}
}

