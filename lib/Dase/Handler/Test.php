<?php

class Dase_Handler_Test extends Dase_Handler
{
		public $resource_map = array(
				'/' => 'tests',
				'matrix' => 'matrix',
				'regression' => 'regression',
				'correlation' => 'correlation',
		);

		protected function setup($r)
		{
				$this->user = $r->getUser();
		}

		public function getTests($r) 
		{
		}

		public function getMatrix($r)
		{
				$matrix = array(
						array(2,3,4,5),
						array(2,3,4,5),
						array(2,3,4,5),
						array(2,3,4,5),
				);

				$lm = new  Lib_Matrix($matrix);
				$lm->DisplayMatrix();
				exit;
		}

		public function getRegression($r)
		{
				$x = array(2,3,4,5,3,3,3,3,3,8,3,9,3,3,3,3,3,3,3,3,3,3,33,33,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,0,3,33,3,33,3,3,3,3,3,9,3,3);
				$y = array(1,2,3,5,5,3,3,3,3,3,7,3,9,0,3,303,3,3,0,3,3,0,30,33,0,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,0,3,33,3,33,3,3,3,3,3,9,3,3);
				print_r(Math::linearRegression($x,$y));
				exit;
		}

		public function getCorrelation($r)
		{
				$x = array(2,3,4,5);
				$y = array(1,2,3,5);
				$m = new Math();
				print_r($m->Correlation($x,$y));
				exit;
		}
}

