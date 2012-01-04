<?php

class SsToJson {

		public function __construct() {
		}

		public static function run($request,&$template,$node)
		{
				//from http://www.ravelrumba.com/blog/json-google-spreadsheets/
				$key = $request->get('key');
				if ($key) {
						$feed = 'https://docs.google.com/spreadsheet/pub?key='.$key.'&output=csv';
						// Arrays we'll use later
						$keys = array();
						$newArray = array();

						// Do it
						$data = SsToJson::csvToArray($feed, ',');

						// Set number of elements (minus 1 because we shift off the first row)
						$count = count($data) - 1;

						//Use first row for names  
						$labels = array_shift($data);  

						foreach ($labels as $label) {
								$keys[] = $label;
						}


						// Bring it all together
						for ($j = 0; $j < $count; $j++) {
								$d = array_combine($keys, $data[$j]);
								$newArray[$j] = $d;
						}

						// Print it out as JSON
						header('Content-type: application/json');
						echo json_encode($newArray);
						exit;
				} else {
						echo 'missing "key" parameter';
						exit;
				}
		}	

		//Function to convert CSV into associative array
		public static function csvToArray($file, $delimiter) { 
				if (($handle = fopen($file, 'r')) !== FALSE) { 
						$i = 0; 
						while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) { 

								//gets length of first row
								if (!isset($columns)) {
										$columns = count($lineArray);
								}

								for ($j = 0; $j < $columns; $j++) { 
										$arr[$i][$j] = $lineArray[$j]; 
								} 
								$i++; 
						} 
						fclose($handle); 
				} 
				return $arr; 
		} 

}

