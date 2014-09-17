<?php
session_start();

function getData($key) {

    if (isset($_SESSION['storage'][$key])) {
        return $_SESSION['storage'][$key];
    }

    return null;
}

function setData($key, $val) {

    $_SESSION['storage'][$key] = $val;

    return $val;
}

function initStorage() {

    $storage = array();
    if (isset($_SESSION['storage'])) {
        $storage = $_SESSION['storage'];
    } else {
        $_SESSION['storage'] = $storage;
    }

    return $storage;
}

function resetStorage() {
    $_SESSION['storage'] = array();
}

function printStorage() {
    p($_SESSION['storage']);
}

initStorage();