<?php

$host   = "SAMITPCGENIUS"; // or user ip 127.0.0.1 or   Server name is "DESKTOP-5KFFN0F"
$user   = "sa";
$pass   = "377040";
$dbname = "openfiredb";

try {
    $connect = new PDO(
        "sqlsrv:Server=" . $host . ";Database=" . $dbname, 
        $user, 
        $pass
    );
    $connect->exec("SET NAMES 'utf8'");
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "connect database success";

}
catch (Exception $e)
{
    die(print_r($e->getMessage()));
}