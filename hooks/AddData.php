<?php

class AddData {

		public function __construct() {
		}

		public static function run($request,&$template,$node)
		{
				$user = $request->getUser();
				$ds = new Dase_DBO_DataSet($node->db);
				$ds->created_by = $user->eid;
				$template->assign('data_sets',$ds->findAll(1));
		}	
}

