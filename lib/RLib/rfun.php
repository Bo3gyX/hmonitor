<?php
function e($str){
    echo getStrOfType($str)."<br/>\n";
}

function p($str){
    echo "<pre>\n";
    print_r($str)."\n";
    echo "</pre>\n";
}

function v($str){
    echo "<pre>\n";
    var_dump($str)."\n";
    echo "</pre>\n";
}

function getStrOfType($type){

    $str = '';

    if ($type === false) $str = 'FALSE';
    elseif ($type === true) $str = 'TRUE';
    elseif ($type === null) $str = 'NULL';
    else $str = $type;

    return $str;
}