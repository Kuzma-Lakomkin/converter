<?php 

ini_set('display_errors', 1);
error_reporting(-1);


function debug($data)
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}