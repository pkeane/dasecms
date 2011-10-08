<?php
include 'config.php';

foreach ($db->listTables() as $table) {
		print $table."\n";
		foreach ($db->listColumns($table) as $col) {
				print "\t".$col."\n";
		}
		print "------------------------\n\n";
}

