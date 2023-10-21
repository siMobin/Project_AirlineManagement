<?php include './nav.php'; ?>
<?php require_once('./conn.php'); ?>
<?php include './side_bar.php' ?>
<?php
$sql = "SELECT id, [from], [to], date, return_date, class, passengers, email, phone, trip, cost FROM bookings WHERE date >= CONVERT(date, GETDATE()) UNION ALL SELECT id, [from], [to], return_date as date, return_date, class, passengers, email, phone, trip, cost FROM bookings WHERE return_date >= CONVERT(date, GETDATE()) ORDER BY date";
$stmt = sqlsrv_query($conn, $sql);

echo "<table>";
echo "<tr><th>FID</th><th>From</th><th>To</th><th>Date</th><th>Class</th><th>Passengers</th><th>Email</th><th>Phone</th><th>Trip</th><th>Cost</th></tr>";

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
     $date = $row['date'];
     if ($date !== null) {
          $formatted_date = $date->format('Y-m-d');
          if ($row['trip'] == 'round-trip' && $row['date'] == $row['return_date']) {
               echo "<tr>";
               echo "<td>" . $row['id'] . "</td>";
               echo "<td>" . $row['to'] . "</td>";
               echo "<td>" . $row['from'] . "</td>";
               echo "<td>" . $formatted_date . "</td>";
               echo "<td>" . $row['class'] . "</td>";
               echo "<td>" . $row['passengers'] . "</td>";
               echo "<td>" . $row['email'] . "</td>";
               echo "<td>" . $row['phone'] . "</td>";
               echo "<td>" . $row['trip'] . "</td>";
               echo "<td>" . $row['cost'] . "</td>";
               echo "</tr>";
          } else {
               echo "<tr>";
               echo "<td>" . $row['id'] . "</td>";
               echo "<td>" . $row['from'] . "</td>";
               echo "<td>" . $row['to'] . "</td>";
               echo "<td>" . $formatted_date . "</td>";
               echo "<td>" . $row['class'] . "</td>";
               echo "<td>" . $row['passengers'] . "</td>";
               echo "<td>" . $row['email'] . "</td>";
               echo "<td>" . $row['phone'] . "</td>";
               echo "<td>" . $row['trip'] . "</td>";
               echo "<td>" . $row['cost'] . "</td>";
               echo "</tr>";
          }
     }
}
sqlsrv_free_stmt($stmt);
?>

<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Flight Schedule</title>
     <link rel="stylesheet" href="./style/schedule.css">
</head>

<body>

</body>

</html>