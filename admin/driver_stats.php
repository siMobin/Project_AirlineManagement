<?php
// Query and fetch data for pilots and co-pilots
$pilotSql = "SELECT D.DID, D.name, 
           COUNT(*) AS assignment_count,
           SUM(CASE WHEN F.pilot = D.DID THEN 1 ELSE 0 END) AS pilot_count,
           SUM(CASE WHEN F.co_pilot = D.DID THEN 1 ELSE 0 END) AS co_pilot_count
    FROM driver_info D
    LEFT JOIN flight_assign F ON D.DID = F.pilot OR D.DID = F.co_pilot
    WHERE D.roll IN ('pilot', 'co-pilot')
    GROUP BY D.DID, D.name";

$pilotData = array();

$pilotStmt = sqlsrv_query($conn, $pilotSql);
if ($pilotStmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

while ($row = sqlsrv_fetch_array($pilotStmt, SQLSRV_FETCH_ASSOC)) {
    $pilotData[$row['DID']] = array(
        'name' => $row['name'],
        'assignment_count' => $row['assignment_count'],
        'pilot_count' => $row['pilot_count'],
        'co_pilot_count' => $row['co_pilot_count']
    );
}

sqlsrv_free_stmt($pilotStmt);

// Query and fetch data for hostesses, co-hostesses, and co-hostess secondary
$hostessSql = "SELECT D.DID, D.name, 
           COUNT(*) AS assignment_count,
           SUM(CASE WHEN F.hostess = D.DID THEN 1 ELSE 0 END) AS hostess_count,
           SUM(CASE WHEN F.co_hostess = D.DID THEN 1 ELSE 0 END) AS co_hostess_count,
           SUM(CASE WHEN F.co_hostess_secondary = D.DID THEN 1 ELSE 0 END) AS co_hostess_secondary_count
    FROM driver_info D
    LEFT JOIN flight_assign F ON D.DID = F.hostess OR D.DID = F.co_hostess OR D.DID = F.co_hostess_secondary
    WHERE D.roll IN ('hostess', 'co-hostess', 'co-hostess-secondary')
    GROUP BY D.DID, D.name";

$hostessData = array();

$hostessStmt = sqlsrv_query($conn, $hostessSql);
if ($hostessStmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

while ($row = sqlsrv_fetch_array($hostessStmt, SQLSRV_FETCH_ASSOC)) {
    $hostessData[$row['DID']] = array(
        'name' => $row['name'],
        'assignment_count' => $row['assignment_count'],
        'hostess_count' => $row['hostess_count'],
        'co_hostess_count' => $row['co_hostess_count'],
        'co_hostess_secondary_count' => $row['co_hostess_secondary_count']
    );
}
// Sort pilot data by name
usort($pilotData, function ($a, $b) {
    return strcmp($a['name'], $b['name']);
});
// Sort hostess data by name
usort($hostessData, function ($a, $b) {
    return strcmp($a['name'], $b['name']);
});

sqlsrv_free_stmt($hostessStmt);
sqlsrv_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Driver Assignment Chart</title>
    <link rel="stylesheet" href="./style/stats.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="can">
        <div class="block">
            <canvas id="pilotChart"></canvas>
        </div>
        <div class="block">
            <canvas id="hostessChart"></canvas>
        </div>
    </div>
    <script>
        var pilotData = <?php echo json_encode(array_values($pilotData)); ?>;
        var hostessData = <?php echo json_encode(array_values($hostessData)); ?>;
    </script>
</body>

</html>