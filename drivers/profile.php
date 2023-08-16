<?php require_once('./nav.php'); ?>
<?php
require('./conn.php');

// Get the driver's ID from the session
$driver_id = $_SESSION["driver_id"];

// Retrieve driver's name
$query = "SELECT name FROM driver WHERE DID = ?";
$params = array($driver_id);
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$name = "";
if (sqlsrv_has_rows($stmt)) {
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $name = $row["name"];
}

// Retrieve flight assignments and roles
$query = "SELECT fa.id, fa.date, fa.pilot, fa.co_pilot, fa.hostess, fa.co_hostess, fa.co_hostess_secondary, b.[from], b.[to], b.trip
          FROM flight_assign fa
          INNER JOIN bookings b ON fa.id = b.id
          WHERE fa.pilot = ? OR fa.co_pilot = ? OR fa.hostess = ? OR fa.co_hostess = ? OR fa.co_hostess_secondary = ?";
$params = array($driver_id, $driver_id, $driver_id, $driver_id, $driver_id);
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Driver Profile</title>
</head>

<body>
    <h2>Welcome, <?php echo $name; ?></h2>

    <h3>Your Flight Assignments:</h3>
    <table>
        <tr>
            <th>Flight ID</th>
            <th>Date</th>
            <th>Role</th>
            <th>From</th>
            <th>To</th>
            <th>Trip</th>
        </tr>
        <?php
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $role = "";
            if ($row["pilot"] == $driver_id) {
                $role = "Pilot";
            } elseif ($row["co_pilot"] == $driver_id) {
                $role = "Co-Pilot";
            } elseif ($row["hostess"] == $driver_id) {
                $role = "Hostess";
            } elseif ($row["co_hostess"] == $driver_id) {
                $role = "Co-Hostess";
            } elseif ($row["co_hostess_secondary"] == $driver_id) {
                $role = "Secondary Co-Hostess";
            }

            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["date"]->format('Y-m-d') . "</td>";
            echo "<td>" . $role . "</td>";
            echo "<td>" . $row["from"] . "</td>";
            echo "<td>" . $row["to"] . "</td>";
            echo "<td>" . $row["trip"] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>

</html>