<?php

include 'config.php';

$sql = "
CREATE TABLE `attachment` (
	`id` int(11) NOT NULL auto_increment,
	`name` varchar(40) collate utf8_unicode_ci default NULL,
	`node_id` int(11) NOT NULL,
	`nodeset_id` int(11) NOT NULL,
	PRIMARY KEY  (`id`)
) ENGINE=INNODB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
";

$dbh = $db->getDbh();
$sth = $dbh->prepare($sql);
print_r($sth->execute());
