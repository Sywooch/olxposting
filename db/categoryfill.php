<?php

include_once 'db/dbConn.php';

$file = 'resultCat.txt';
$rawData = file_get_contents($file);

$dataArray = explode("\n", $rawData);
$array = [];
foreach ($dataArray as $item) {
    $del = explode(",", $item);
    array_push($array, $del);
}

$db = dbConn();

foreach ($array as $item) {
//    $sql = $db->prepare('INSERT INTO `cat` (`id`, `cat1`, `cat2`, `cat3`, `cat4`) VALUES (NULL, ?, ?, ?, ?)');
//    $sql->execute($item);
    print_r($item);
}