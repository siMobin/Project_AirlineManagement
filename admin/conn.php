<?php
// $serverName = "localhost";
//OR
$serverName = "127.0.0.1"; // localhost ip-----OR----enable any existing ip from SQL Server (2022) Configuration manager\SQL Server Network Configuration\protocols For SQLEXPRESS(instance name)\TCP/IP\properties\protocol(enabled)\IP Address
$port = "51609"; // The port, configured in SQL Server Configuration Manager
$connectionOptions = array(
    "Database" => "PrivateJet" //database name
);

$conn = sqlsrv_connect("$serverName, $port", $connectionOptions);

if (!$conn) {
    die(print_r(sqlsrv_errors(), true));
}
