<?php
require("./conn.php");
$query = "SELECT class, SUM(cost) as total_earnings FROM bookings GROUP BY class";
$result = sqlsrv_query($conn, $query);

$data = array();
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $data[] = $row;
}

sqlsrv_close($conn);

// Sort the data by total earnings in descending order to find the most earning class
usort($data, function ($a, $b) {
    return $b['total_earnings'] - $a['total_earnings'];
});

$mostEarningClass = $data[0]['class'];
$earnings = $data[0]['total_earnings'];

?>

<canvas id="class$"></canvas>


<script>
    var data = <?php echo json_encode($data); ?>;
</script>

<script src="./class_percent_cost.js"></script>