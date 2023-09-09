<?php require_once('./nav.php'); ?>
<?php
require('./conn.php');

$inserted = false;
$error = false;
$bookingForms = array(); // Initialize the array
$sleep = 6; //driver unavailable days

if ($conn === false) {
    $error = true;
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission and insertion, as before
    $bookingId = $_POST['booking_id'];
    $pilotId = $_POST['pilot_id'];
    $coPilotId = $_POST['co_pilot_id'];
    $hostessId = $_POST['hostess_id'];
    $coHostessId = $_POST['co_hostess_id'];
    $coHostessSecondaryId = $_POST['co_hostess_secondary_id'];
    $flightDate = $_POST['flight_date'];

    $insertQuery = "INSERT INTO flight_assign (id, pilot, co_pilot, hostess, co_hostess, co_hostess_secondary, date) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $params = array($bookingId, $pilotId, $coPilotId, $hostessId, $coHostessId, $coHostessSecondaryId, $flightDate);
    $insertResult = sqlsrv_query($conn, $insertQuery, $params);

    if ($insertResult === false) {
        $error = true;
    } else {
        $inserted = true;
    }
} else {
    // $currentdate = date('Y-m-d');
    // Retrieve default booking information
    $defaultQuery = "SELECT id, date FROM bookings WHERE date >= CONVERT(date, GETDATE()) UNION ALL SELECT id, return_date as date FROM bookings WHERE return_date >= CONVERT(date, GETDATE()) ORDER BY date ASC";
    $defaultResult = sqlsrv_query($conn, $defaultQuery);

    // Check query execution result
    if ($defaultResult === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Retrieve IDs from the flight_assign table
    $assignedIdsQuery = "SELECT DISTINCT id FROM flight_assign";
    $assignedIdsResult = sqlsrv_query($conn, $assignedIdsQuery);

    // Check query execution result
    if ($assignedIdsResult === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $assignedIds = array();
    while ($assignedIdRow = sqlsrv_fetch_array($assignedIdsResult, SQLSRV_FETCH_ASSOC)) {
        $assignedIds[] = $assignedIdRow['id'];
    }

    while ($defaultRow = sqlsrv_fetch_array($defaultResult, SQLSRV_FETCH_ASSOC)) {
        $defaultBookingId = $defaultRow['id'];
        $defaultFlightDate = $defaultRow['date']->format('Y-m-d');

        // Check if the booking ID is already assigned
        if (in_array($defaultBookingId, $assignedIds)) {
            continue; // Skip this booking
        }

        // Check if any assigned driver's flight date is within the next $sleep days from this booking's date
        $driverAvailabilityQuery = "SELECT DISTINCT pilot, co_pilot, hostess, co_hostess, co_hostess_secondary, MAX(date) AS last_flight_date FROM flight_assign WHERE DATEDIFF(DAY, '$defaultFlightDate', date) <= $sleep GROUP BY pilot, co_pilot, hostess, co_hostess, co_hostess_secondary";
        $driverAvailabilityResult = sqlsrv_query($conn, $driverAvailabilityQuery);

        // Check query execution result
        if ($driverAvailabilityResult === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $unavailableDriverIds = array();
        while ($driverRow = sqlsrv_fetch_array($driverAvailabilityResult, SQLSRV_FETCH_ASSOC)) {
            $lastFlightDate = $driverRow['last_flight_date']->format('Y-m-d');
            $daysDiff = date_diff(new DateTime($lastFlightDate), new DateTime($defaultFlightDate))->days;

            if ($daysDiff <= $sleep) {
                $unavailableDriverIds[] = $driverRow['pilot'];
                $unavailableDriverIds[] = $driverRow['co_pilot'];
                $unavailableDriverIds[] = $driverRow['hostess'];
                $unavailableDriverIds[] = $driverRow['co_hostess'];
                $unavailableDriverIds[] = $driverRow['co_hostess_secondary'];
            }
        }

        // Retrieve pilot and hostess data for dropdown menus, excluding unavailable drivers
        if (!empty($unavailableDriverIds)) {
            $driverQuery = "SELECT DID, name, role FROM driver_info WHERE DID NOT IN (" . implode(",", $unavailableDriverIds) . ")";
        } else {
            $driverQuery = "SELECT DID, name, role FROM driver_info";
        }

        $driverResult = sqlsrv_query($conn, $driverQuery);

        // Check query execution result
        if ($driverResult === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $pilotOptions = "";
        $hostessOptions = "";

        while ($driverRow = sqlsrv_fetch_array($driverResult, SQLSRV_FETCH_ASSOC)) {
            $driverId = $driverRow['DID'];
            $driverName = $driverRow['name'];
            $driverrole = $driverRow['role'];

            $option = "<option value='$driverId'>$driverName</option>";

            if ($driverrole === 'pilot') {
                $pilotOptions .= $option;
            } elseif ($driverrole === 'hostess') {
                $hostessOptions .= $option;
            }
        }

        // Create a form for each booking
        $bookingForms[] = "
        <form action='{$_SERVER['PHP_SELF']}' method='post'>

    <div class='info'>
        <div class='id'>
    <label for='booking_id_$defaultBookingId'>Booking ID:</label>
    <input type='text' id='booking_id_$defaultBookingId' name='booking_id' value='$defaultBookingId' required onkeydown='return false'>
</div>
<div class='date'>
    <label for='flight_date_$defaultBookingId'>Flight Date:</label>
    <input type='date' id='flight_date_$defaultBookingId' name='flight_date' value='$defaultFlightDate' required onkeydown='return false'>
</div>
</div>



<div class='pilot'>
    <div>
    <label for='pilot_id_$defaultBookingId'>Pilot:</label>
    <select id='pilot_id_$defaultBookingId' name='pilot_id' required>
        $pilotOptions
    </select>
</div>
    <div>
    <label for='co_pilot_id_$defaultBookingId'>Co-Pilot:</label>
    <select id='co_pilot_id_$defaultBookingId' name='co_pilot_id'>
        <option value=''>Select Co-Pilot</option>
        $pilotOptions
    </select>
</div>
</div>

<div class='hostess'>
    <div>

    <label for='hostess_id_$defaultBookingId'>Hostess:</label>
    <select id='hostess_id_$defaultBookingId' name='hostess_id' required>
        $hostessOptions
    </select>

</div>
    <div>
    <label for='co_hostess_id_$defaultBookingId'>Co-Hostess:</label>
    <select id='co_hostess_id_$defaultBookingId' name='co_hostess_id'>
        <option value=''>Select Co-Hostess</option>
        $hostessOptions
    </select>
</div>
    <div>

    <label for='co_hostess_secondary_id_$defaultBookingId'>Co-Hostess Secondary:</label>
    <select id='co_hostess_secondary_id_$defaultBookingId' name='co_hostess_secondary_id'>
        <option value=''>Select Co-Hostess Secondary</option>
        $hostessOptions
    </select></div>
</div>

    <input class='assign submit' type='submit' value='Assign Flight'>
</form>";
    }

    sqlsrv_close($conn);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Flight Assignment Form</title>
    <link rel="stylesheet" href="./style/flight_assign.css">
</head>

<body>
    <h2>Flight Assignment</h2>

    <?php
    if ($inserted) {
        header("Location: ./flight_assign.php");
    } elseif ($error) {
        echo "<p>Error inserting flight assignment. Please try again later.</p>";
    }

    // Display the generated forms
    foreach ($bookingForms as $form) {
        echo $form;
    }
    ?>
</body>

</html>