<?php
// Retrieve user's latitude and longitude from POST data
$userLatitude = $_POST['latitude'];
$userLongitude = $_POST['longitude'];

// Set the database connection details
require_once('./conn.php');

// Query the database based on the user's location and calculate the distance
$query = "SELECT id, destination, latitude, longitude, hotel, hotline,
          (6371 * ACOS(COS(RADIANS($userLatitude)) * COS(RADIANS(latitude)) * COS(RADIANS(longitude) - RADIANS($userLongitude)) + SIN(RADIANS($userLatitude)) * SIN(RADIANS(latitude)))) AS distance
          FROM (
              SELECT *,
                  (6371 * ACOS(COS(RADIANS($userLatitude)) * COS(RADIANS(latitude)) * COS(RADIANS(longitude) - RADIANS($userLongitude)) + SIN(RADIANS($userLatitude)) * SIN(RADIANS(latitude)))) AS distance
              FROM locations
          ) AS subquery
          WHERE distance <= 100"; //'100'! the desired search radius in kilometers

$result = sqlsrv_query($conn, $query);

if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Construct the HTML response
$response = "";

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $response .= "<p><strong>Nearest Airport:</strong> " . $row["destination"] . "<br>";
    $response .= "<strong>Distance:</strong> " . number_format($row["distance"], 2) . " KM<br>";
    $response .= "<strong>Recommended Hotel:</strong> " . $row["hotel"] . "<br>";
    $response .= "<strong>Customer Support:</strong> " . $row["hotline"] . "</p>";
}
sqlsrv_close($conn);

// Return the HTML response
echo $response;
?>

<!-- insert json data -->
<script src="default_locations.json"></script>