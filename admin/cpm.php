<?php require('./conn.php'); ?>
<?php
//round trip validation
$sql = "SELECT YEAR(date) AS year, MONTH(date) AS month, SUM(CASE WHEN trip = 'round-trip' THEN cost/2 ELSE cost END) AS total
FROM bookings
WHERE date >= DATEADD(month, -12, GETDATE())
GROUP BY YEAR(date), MONTH(date)
ORDER BY YEAR(date), MONTH(date);";
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

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
    <canvas id="cpm"></canvas>

    <script>
        var chartData = {
            labels: <?php echo json_encode(array_column($data, 'month')); ?>,
            data: <?php echo json_encode(array_column($data, 'total')); ?>
        };
    </script>
</body>

</html>