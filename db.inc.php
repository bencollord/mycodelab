<?php
require_once('config.php');

if (!isset($dbConn)) {
    try {
        $dbConn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
        echo 'Whoops! An error occured!' . $e->getMessage();
    }
}
?>