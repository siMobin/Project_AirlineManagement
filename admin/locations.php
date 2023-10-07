<?php
include './nav.php';
include './side_bar.php';
require './conn.php';
?>
<?php
if (isset($_POST['submit'])) {
    $destination = $_POST['destination'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $hotel = $_POST['hotel'];
    $hotline = $_POST['hotline'];

    $sql = "INSERT INTO locations (destination, latitude, longitude,hotel,hotline) VALUES (?, ?, ?,?,?)";
    $params = array($destination, $latitude, $longitude, $hotel, $hotline);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}

// Delete a row from the database when the delete button is clicked
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM locations WHERE id = ?";
    $params = array($id);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}

// Show all destinations from the table locations sorted by their primary key "id" before the form
$sql = "SELECT * FROM locations ORDER BY destination";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

echo "<h1>airport list/Destinations</h1>";
echo "<div class='table'>";
echo "<table>";
echo "<tr><th>Destination</th><th>Latitude</th><th>Longitude</th><th>Hotel</th><th>Hotline</th><th>Delete</th></tr>";
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row['destination'] . "</td>";
    echo "<td>" . $row['latitude'] . "</td>";
    echo "<td>" . $row['longitude'] . "</td>";
    echo "<td>" . $row['hotel'] . "</td>";
    echo "<td>" . $row['hotline'] . "</td>";
    // echo "<td><form method='post'><input type='hidden' name='id' value='" . $row['id'] . "'><input type='submit' name='delete' value='Delete'></form></td>";
    echo "<td><form method='post'><input type='hidden' name='id' value='" . $row['id'] . "'><button class='delete' type='submit' name='delete'><i class='fa fa-trash'></i></button></form></td>";

    echo "</tr>";
}
echo "</table>";
echo "</div>";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/locations.css">
    <title>Airport Management</title>
</head>

<body>
    <h1>Add new airport</h1>
    <form method="post">
        <div class="airport">
            <div class="box">
                <label for="destination">Destination</label>
                <input type="text" id="destination" name="destination" required placeholder="airport name">
            </div>
            <div class="box">
                <label for="latitude">Latitude</label>
                <input type="text" id="latitude" name="latitude" required placeholder="d(N,S) + (m/60) + (s/3600)">
            </div>
            <div class="box">
                <label for="longitude">Longitude</label>
                <input type="text" id="longitude" name="longitude" required placeholder="d(E,W) + (m/60) + (s/3600)">
            </div>
        </div>

        <div class="extra_info">
            <div class="box">
                <label for="hotel">Hotel Name</label>
                <input type="text" id="hotel" name="hotel" required placeholder="hotel name">
            </div>
            <div class="box">
                <label for="hotline">Hotline</label>
                <input type="text" id="hotline" name="hotline" required placeholder="phone number">
            </div>
            <div class="box">
                <label class="empty">&nbsp;&nbsp;</label><!-- empty label for space -->
                <input class="submit" type="submit" name="submit" value="Submit">
            </div>
        </div>
    </form>
    <?php include './map.php'; ?>
</body>

</html>