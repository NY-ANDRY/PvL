<?php
include "functions.php";

$location = $_GET['path'];

$name = explode('/', $location);
$name = end($name);
$parent = str_replace($name, '', $location);
$parent = str_replace('../', '', $parent);

$parent = "/$parent";
if ($name === '..') {
    $name = 'root';
}

$result = [
    'name' => $name,
    'parent' => $parent,
    'size' => formatSize(getSize($location)),
    'creation' => getCreationDate($location),
    'lastModified' => getLastModificationDate($location)
];

echo json_encode($result);