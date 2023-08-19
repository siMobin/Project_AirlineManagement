<?php
include './nav.php';
require './conn.php'
?>
<?php
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

echo "<h1>airport list/Destinations</h1>";
echo "<div class='table'>";
echo "<table>";
echo "<tr><th>Destination</th><th>Latitude</th><th>Longitude</th><th>Delete</th></tr>";
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row['destination'] . "</td>";
    echo "<td>" . $row['latitude'] . "</td>";
    echo "<td>" . $row['longitude'] . "</td>";
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
        <label for="destination">Destination:</label>
        <input type="text" id="destination" name="destination" required placeholder="airport name">
        <label for="latitude">Latitude:</label>
        <input type="text" id="latitude" name="latitude" required placeholder="d(N,S) + (m/60) + (s/3600)">
        <label for="longitude">Longitude:</label>
        <input type="text" id="longitude" name="longitude" required placeholder="d(E,W) + (m/60) + (s/3600)">
        <input class="submit" type="submit" name="submit" value="Submit">
    </form>
    <?php include './map.php'; ?>
</body>

</html>