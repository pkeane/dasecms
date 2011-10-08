<?php

include 'config.php';

$sql = "
CREATE TABLE `sorter` (
	`id` int(11) NOT NULL auto_increment,
	`att_ascii` varchar(200) collate utf8_unicode_ci NOT NULL,
	`is_descending` tinyint(1) default NULL,
	PRIMARY KEY  (`id`)
) ENGINE=INNODB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
";

$dbh = $db->getDbh();
$sth = $dbh->prepare($sql);
print_r($sth->execute());
