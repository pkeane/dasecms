<?php

include 'config.php';

$sql = "
CREATE TABLE `filter` (
	`id` int(11) NOT NULL auto_increment,
	`att_ascii` varchar(200) collate utf8_unicode_ci NOT NULL,
	`operator` varchar(40) collate utf8_unicode_ci NOT NULL,
	`value` varchar(500) default NULL,
	PRIMARY KEY  (`id`)
) ENGINE=INNODB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
";

$dbh = $db->getDbh();
$sth = $dbh->prepare($sql);
print_r($sth->execute());
