<?php
require('./conn.php');

$sql = "SELECT * FROM locations";
$stmt = sqlsrv_query($conn, $sql);

// Check if the query was successful
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Fetch the results
$locations = array();
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $locations[] = array("lat" => $row['latitude'], "lng" => $row['longitude'], "name" => $row['destination']);
}

// Clean up location names to prevent syntax errors in JSON
foreach ($locations as &$location) {
    $location['name'] = htmlspecialchars($location['name'], ENT_QUOTES, 'UTF-8');
}

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="./style/map.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>

<body>
    <div id="map"></div>
    <script>
        var locations = <?php echo json_encode($locations); ?>;
    </script>
    <script src="./map.js"></script>
</body>

</html>