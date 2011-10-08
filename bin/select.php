<?php

include 'config.php';
$sql = "SELECT * FROM `attachment`";
$dbh = $db->getDbh();
$sth = $dbh->prepare($sql);
$sth->execute();
print_r($sth->fetchAll());
