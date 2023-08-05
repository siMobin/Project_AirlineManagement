<?php
$serverName = "DESKTOP-34HOJHD\SQLEXPRESS2";
$connectionInfo = array("Database"=>"airTest");
$conn = sqlsrv_connect($serverName, $connectionInfo);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

if (isset($_POST['submit'])) {
    $destination = $_POST['destination'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    $tsql = "INSERT INTO locations (destination, latitude, longitude) VALUES (?, ?, ?)";
    $params = array($destination, $latitude, $longitude);
    $stmt = sqlsrv_query($conn, $tsql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}

// Delete a row from the database when the delete button is clicked
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $tsql = "DELETE FROM locations WHERE id = ?";
    $params = array($id);
    $stmt = sqlsrv_query($conn, $tsql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}

// Show all destinations from the table locations sorted by their primary key "id" before the form
$tsql = "SELECT * FROM locations ORDER BY destination";
$stmt = sqlsrv_query($conn, $tsql);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

echo "<h2>Destinations:</h2>";
echo "<table>";
echo "<tr><th>Destination</th><th>Latitude</th><th>Longitude</th><th></th></tr>";
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row['destination'] . "</td>";
    echo "<td>" . $row['latitude'] . "</td>";
    echo "<td>" . $row['longitude'] . "</td>";
    echo "<td><form method='post'><input type='hidden' name='id' value='" . $row['id'] . "'><input type='submit' name='delete' value='Delete'></form></td>";
    echo "</tr>";
}
echo "</table>";
?>

<form method="post">
    <label for="destination">Destination:</label>
    <input type="text" id="destination" name="destination" required><br><br>
    <label for="latitude">Latitude:</label>
    <input type="text" id="latitude" name="latitude" required><br><br>
    <label for="longitude">Longitude:</label>
    <input type="text" id="longitude" name="longitude" required><br><br>
    <input type="submit" name="submit" value="Submit">
</form>
