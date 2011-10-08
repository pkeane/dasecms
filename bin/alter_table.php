<?php

include 'config.php';

$sql = "ALTER TABLE nodeset ADD COLUMN description TEXT";
$sql = "ALTER TABLE nodeset ADD COLUMN cache TEXT";
$sql = "ALTER TABLE attachment DROP COLUMN nodeset_id";
$sql = "ALTER TABLE attachment ADD COLUMN child_id int(11)";
$sql = "ALTER TABLE attachment ADD COLUMN child_type varchar(20)";

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
