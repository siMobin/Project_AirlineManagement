<?php
// Set the database connection details
$serverName = "ACER_LAPTOP\SQLEXPRESS"; //DESKTOP-34HOJHD\SQLEXPRESS2,ACER_LAPTOP\SQLEXPRESS
$connectionInfo = array("Database" => "airTest");
$conn = sqlsrv_connect($serverName, $connectionInfo);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}
