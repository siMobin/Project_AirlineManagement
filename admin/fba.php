<?php require('./conn.php'); ?>
<?php
$startDate = date('Y-m-d', strtotime('-12 months'));

// Query all airports
$sqlAllAirports = "SELECT DISTINCT [from] as airport FROM bookings UNION SELECT DISTINCT [to] as airport FROM bookings";
$stmtAllAirports = sqlsrv_query($conn, $sqlAllAirports);
$allAirports = array();
while ($row = sqlsrv_fetch_array($stmtAllAirports, SQLSRV_FETCH_ASSOC)) {
    $allAirports[] = $row['airport'];
}

// Query flight starts data from the bookings table
$sqlStart = "SELECT [from] as airport, COUNT(*) as flight_count FROM bookings WHERE date >= ? GROUP BY [from] ORDER BY flight_count DESC";
$stmtStart = sqlsrv_query($conn, $sqlStart, array($startDate));
$flightDataStart = array();
while ($row = sqlsrv_fetch_array($stmtStart, SQLSRV_FETCH_ASSOC)) {
    $flightDataStart[$row['airport']] = $row['flight_count'];
}

// Query flight destinations data from the bookings table
$sqlDestination = "SELECT [to] as airport, COUNT(*) as flight_count FROM bookings WHERE date >= ? GROUP BY [to] ORDER BY flight_count DESC";
$stmtDestination = sqlsrv_query($conn, $sqlDestination, array($startDate));
$flightDataDestination = array();
while ($row = sqlsrv_fetch_array($stmtDestination, SQLSRV_FETCH_ASSOC)) {
    $flightDataDestination[$row['airport']] = $row['flight_count'];
}

// Process the data for Chart.js
$airportNames = array();
$flightCountsStart = array();
$flightCountsDestination = array();

// Process all airports
foreach ($allAirports as $airport) {
    $airportNames[] = htmlspecialchars($airport);
    $flightCountsStart[] = isset($flightDataStart[$airport]) ? $flightDataStart[$airport] : 0;
    $flightCountsDestination[] = isset($flightDataDestination[$airport]) ? $flightDataDestination[$airport] : 0;
}
?>
<!DOCTYPE html>
<html>

<body>
    <canvas id="fba"></canvas>
    <script>
        // PHP data from server
        var airportNames = <?php echo json_encode($airportNames); ?>;
        var flightCountsStart = <?php echo json_encode($flightCountsStart); ?>;
        var flightCountsDestination = <?php echo json_encode($flightCountsDestination); ?>;
    </script>
</body>

</html>