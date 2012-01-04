<?php


//from http://richardathome.wordpress.com/2006/01/25/a-php-linear-regression-function/

/**
 * linear regression function
 * @param $x array x-coords
 * @param $y array y-coords
 * @returns array() m=>slope, b=>intercept
 */

class Math {

		function linearRegression($x, $y) {
				// calculate number points
				$n = count($x);
				// ensure both arrays of points are the same size
				if ($n != count($y)) {
						trigger_error("linear_regression(): Number of elements in coordinate arrays do not match.", E_USER_ERROR);
				}

				// calculate sums
				$x_sum = array_sum($x);
				$y_sum = array_sum($y);

				$xx_sum = 0;
				$xy_sum = 0;
				for($i = 0; $i < $n; $i++) {
						$xy_sum+=($x[$i]*$y[$i]);
						$xx_sum+=($x[$i]*$x[$i]);
				}

				// calculate slope
				$m = (($n * $xy_sum) - ($x_sum * $y_sum)) / (($n * $xx_sum) - ($x_sum * $x_sum));

				// calculate intercept
				$b = ($y_sum - ($m * $x_sum)) / $n;

				// return result
				return array("m"=>$m, "b"=>$b);
		}

		function Correlation($arr1, $arr2)
		{       
				$correlation = 0;

				$k = $this->SumProductMeanDeviation($arr1, $arr2);
				$ssmd1 = $this->SumSquareMeanDeviation($arr1);
				$ssmd2 = $this->SumSquareMeanDeviation($arr2);

				$product = $ssmd1 * $ssmd2;

				$res = sqrt($product);

				$correlation = $k / $res;

				return $correlation;
		}

		function SumProductMeanDeviation($arr1, $arr2)
		{
				$sum = 0;

				$num = count($arr1);

				for($i=0; $i<$num; $i++)
				{
						$sum = $sum + $this->ProductMeanDeviation($arr1, $arr2, $i);
				}

				return $sum;
		}

		function ProductMeanDeviation($arr1, $arr2, $item)
		{
				return ($this->MeanDeviation($arr1, $item) * $this->MeanDeviation($arr2, $item));
		}

		function SumSquareMeanDeviation($arr)
		{
				$sum = 0;

				$num = count($arr);

				for($i=0; $i<$num; $i++)
				{
						$sum = $sum + $this->SquareMeanDeviation($arr, $i);
				}

				return $sum;
		}

		function SquareMeanDeviation($arr, $item)
		{
				return $this->MeanDeviation($arr, $item) * $this->MeanDeviation($arr, $item);
		}

		function SumMeanDeviation($arr)
		{
				$sum = 0;

				$num = count($arr);

				for($i=0; $i<$num; $i++)
				{
						$sum = $sum + $this->MeanDeviation($arr, $i);
				}

				return $sum;
		}

		function MeanDeviation($arr, $item)
		{
				$average = $this->Average($arr);

				return $arr[$item] - $average;
		}   

		function Average($arr)
		{
				$sum = $this->Sum($arr);
				$num = count($arr);

				return $sum/$num;
		}

		function Sum($arr)
		{
				return array_sum($arr);
		}
}


