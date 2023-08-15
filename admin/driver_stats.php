<?php
require('./conn.php');

$sql = "SELECT D.DID, D.name, D.roll, 
           COUNT(*) AS assignment_count,
           SUM(CASE WHEN F.pilot = D.DID THEN 1 ELSE 0 END) AS pilot_count,
           SUM(CASE WHEN F.co_pilot = D.DID THEN 1 ELSE 0 END) AS co_pilot_count,
           SUM(CASE WHEN F.hostess = D.DID THEN 1 ELSE 0 END) AS hostess_count,
           SUM(CASE WHEN F.co_hostess = D.DID THEN 1 ELSE 0 END) AS co_hostess_count,
           SUM(CASE WHEN F.co_hostess_secondary = D.DID THEN 1 ELSE 0 END) AS co_hostess_secondary_count
    FROM driver_info D
    LEFT JOIN flight_assign F ON D.DID IN (F.pilot, F.co_pilot, F.hostess, F.co_hostess, F.co_hostess_secondary)
    GROUP BY D.DID, D.name, D.roll";

$driverData = array();

$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $driverData[$row['DID']] = array(
        'name' => $row['name'],
        'roll' => $row['roll'],
        'assignment_count' => $row['assignment_count'],
        'pilot_count' => $row['pilot_count'],
        'co_pilot_count' => $row['co_pilot_count'],
        'hostess_count' => $row['hostess_count'],
        'co_hostess_count' => $row['co_hostess_count'],
        'co_hostess_secondary_count' => $row['co_hostess_secondary_count']
    );
}

// Sort driver by name
usort($driverData, function ($a, $b) {
    return strcmp($a['name'], $b['name']);
});

sqlsrv_free_stmt($stmt);
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
    <canvas id="assignmentChart"></canvas>
    <script>
        var driverData = <?php echo json_encode(array_values($driverData)); ?>;
    </script>
</body>

</html>