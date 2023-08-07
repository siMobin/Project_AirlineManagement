<?php require('./conn.php'); ?>
<?php
// Query the database for the total passengers by month
$sql = "SELECT TOP 12 YEAR(date) AS Year, MONTH(date) AS Month, SUM(passengers) AS TotalPassengers FROM (SELECT date, passengers FROM bookings WHERE date IS NOT NULL UNION ALL SELECT return_date AS date, passengers FROM bookings WHERE return_date IS NOT NULL) AS combined_data GROUP BY YEAR(date), MONTH(date) ORDER BY YEAR(date) DESC, MONTH(date) DESC";
$stmt = sqlsrv_query($conn, $sql);

// Initialize the data arrays
$labels = array();
$data = array();

// Loop through the query results and add the data to the arrays
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    array_unshift($labels, $row['Year'] . '-' . $row['Month']);
    array_unshift($data, $row['TotalPassengers']);
}

// Close the database connection
sqlsrv_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- Include the Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Create a canvas element for the line chart -->
    <canvas id="ppm"></canvas>
    <script>
        // Call the createLineChart function with the PHP data
        createLineChart(<?php echo json_encode($labels); ?>, <?php echo json_encode($data); ?>);
    </script>
</body>

</html>