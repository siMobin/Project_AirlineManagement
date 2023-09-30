<?php
require("./conn.php");

$query = "SELECT class, COUNT(*) as count FROM bookings GROUP BY class";
$result = sqlsrv_query($conn, $query);

$data = array();
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $data[] = $row;
}

sqlsrv_close($conn);

$totalBookings = array_sum(array_column($data, 'count'));

foreach ($data as &$row) {
    $percentage = ($row['count'] / $totalBookings) * 100;
    $row['percentage'] = $percentage;
}
?>

<canvas id="class%"></canvas>

<script>
    var data = <?php echo json_encode($data); ?>;
</script>

<script src="./class_percent.js"></script>