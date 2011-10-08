<?php

include 'config.php';

$sql = "ALTER TABLE nodeset DROP COLUMN parent_node_id";
$sql = "ALTER TABLE nodeset ADD COLUMN description TEXT";
$sql = "ALTER TABLE nodeset ADD COLUMN cache TEXT";
$sql = "DROP TABLE node_nodeset";

$dbh = $db->getDbh();
$sth = $dbh->prepare($sql);
print_r($sth->execute());
/*
$sql = "ALTER TABLE sorter DROP COLUMN `attachment_id`";
$dbh = $db->getDbh();
$sth = $dbh->prepare($sql);
print_r($sth->execute());
$sql = "ALTER TABLE `filter` ADD COLUMN `nodeset_id` INT NOT NULL";
$dbh = $db->getDbh();
$sth = $dbh->prepare($sql);
print_r($sth->execute());

$sql = "ALTER TABLE `sorter` ADD COLUMN `nodeset_id` INT NOT NULL";
$dbh = $db->getDbh();
$sth = $dbh->prepare($sql);
print_r($sth->execute());
 */
