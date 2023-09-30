<?php require('./conn.php'); ?>
<?php
$sql = "SELECT month_year, SUM(CASE WHEN trip = 'round-trip' THEN cost/2 ELSE cost END) AS total
FROM (
    SELECT FORMAT(date, 'MM-yyyy') AS month_year, date, trip, cost
    FROM bookings
    WHERE date >= DATEADD(month, -12, GETDATE())
) AS subquery
GROUP BY month_year
ORDER BY SUBSTRING(month_year, 4, 4), SUBSTRING(month_year, 1, 2);";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$data = array();
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $data[] = $row;
}

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>

<canvas id="cpm"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var chartLabels = <?php echo json_encode(array_column($data, 'month_year')); ?>;

    var chartData = {
        labels: chartLabels,
        data: <?php echo json_encode(array_column($data, 'total')); ?>
    };
</script>