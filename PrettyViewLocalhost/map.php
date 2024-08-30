<?php
include "functions.php";

$location = "..";

$tunnel = dig($location);
$collection = collectTunnel($tunnel);
$result = json_encode($collection);

if (json_last_error() === JSON_ERROR_NONE) {
    echo $result;
} else {
    echo 'error JSON : ' . json_last_error_msg();
}
