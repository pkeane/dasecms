<?php

class DataSet {

		public function __construct() {
		}

		public static function run($request,&$template,$node)
		{
				$ds = new Dase_DBO_DataSet($node->db);
				if ($ds->load($request->get('id'))) {
						$ds->getPersonData();
						$template->assign('data_set',$ds);
				}
		}	
}

