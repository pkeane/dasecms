<?php


$myarray = range(0,300);

//print_r($myarray);

$json = json_encode($myarray);

print_r(json_decode($json));
