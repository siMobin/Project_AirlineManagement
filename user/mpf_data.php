<?php
require('./conn.php');

$selectedClass = $_POST['selected_class'];

$sql = "SELECT TOP 5 [from],[to], COUNT(*) as count, AVG(cost/passengers) as average_cost FROM bookings WHERE class = ? GROUP BY [from],[to] ORDER BY count DESC";
$params = array($selectedClass);
$stmt = sqlsrv_query($conn, $sql, $params);

echo "<table>";
echo "<tr>
<th>From</th>
<th>To</th>
<th>Average Cost</th>
</tr>";

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row['from'] . "</td>";
    echo "<td>" . $row['to'] . "</td>";
    echo "<td>" . "$ " . number_format($row['average_cost'], 2) . "</td>";
    echo "</tr>";
}
echo "</table>";

/*

// Table data will be inserted in "mpf.js, L35" //

*/

sqlsrv_close($conn);
