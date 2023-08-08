<?php require('./conn.php'); ?>

<?php
// Query to retrieve the data
$sql = "SELECT
RIGHT('00' + CAST(DATEPART(MONTH, date) AS VARCHAR(2)), 2) + '-' + CAST(YEAR(date) AS VARCHAR(4)) AS MonthYear,
SUM(CASE WHEN class = 'economy' THEN passengers ELSE 0 END) AS Economy,
SUM(CASE WHEN class = 'business' THEN passengers ELSE 0 END) AS Business,
SUM(CASE WHEN class = 'first' THEN passengers ELSE 0 END) AS First
FROM bookings
WHERE date >= DATEADD(MONTH, -11, GETDATE()) -- Filter to get data for the last 12 months
GROUP BY YEAR(date), RIGHT('00' + CAST(DATEPART(MONTH, date) AS VARCHAR(2)), 2) + '-' + CAST(YEAR(date) AS VARCHAR(4))
ORDER BY YEAR(date), RIGHT('00' + CAST(DATEPART(MONTH, date) AS VARCHAR(2)), 2) + '-' + CAST(YEAR(date) AS VARCHAR(4));
";
$result = sqlsrv_query($conn, $sql);

// Prepare the data for the chart
$months = [];
$economyData = [];
$businessData = [];
$firstData = [];

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $months[] = $row['MonthYear'];
    $economyData[] = $row['Economy'];
    $businessData[] = $row['Business'];
    $firstData[] = $row['First'];
}

sqlsrv_free_stmt($result);
sqlsrv_close($conn);
?>

<!DOCTYPE html>
<html>

<body>
    <canvas id="ppc"></canvas>
    <script>
        var months = <?php echo json_encode($months); ?>;
        var economyData = <?php echo json_encode($economyData); ?>;
        var businessData = <?php echo json_encode($businessData); ?>;
        var firstData = <?php echo json_encode($firstData); ?>;
    </script>
</body>

</html>