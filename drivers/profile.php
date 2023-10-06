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
$query = "SELECT 
    fa.id AS flight_id, 
    fa.date AS flight_date, 
    b.[from] AS flight_from, 
    b.[to] AS flight_to, 
    ha.hotel AS hotel_name, 
    ha.room_no AS hotel_room_no, 
    ha.checkout_date AS hotel_checkout_date,
    CASE 
        WHEN fa.pilot = ? THEN 'Pilot'
        WHEN fa.co_pilot = ? THEN 'Co-Pilot'
        WHEN fa.hostess = ? THEN 'Hostess'
        WHEN fa.co_hostess = ? THEN 'Co-Hostess'
        WHEN fa.co_hostess_secondary = ? THEN 'Co-Hostess (Secondary)'
        ELSE 'Unknown'
    END AS role
FROM flight_assign AS fa 
LEFT JOIN hotel_assign AS ha ON fa.id = ha.id 
LEFT JOIN bookings AS b ON fa.id = b.id
WHERE (ha.did = ?)
UNION
SELECT 
    fa.id AS flight_id, 
    fa.date AS flight_date, 
    b.[from] AS flight_from, 
    b.[to] AS flight_to, 
    NULL AS hotel_name, 
    NULL AS hotel_room_no, 
    NULL AS hotel_checkout_date,
    CASE 
        WHEN fa.pilot = ? THEN 'Pilot'
        WHEN fa.co_pilot = ? THEN 'Co-Pilot'
        WHEN fa.hostess = ? THEN 'Hostess'
        WHEN fa.co_hostess = ? THEN 'Co-Hostess'
        WHEN fa.co_hostess_secondary = ? THEN 'Co-Hostess (Secondary)'
        ELSE 'Unknown'
    END AS role
FROM flight_assign AS fa 
LEFT JOIN bookings AS b ON fa.id = b.id
WHERE (
    (fa.pilot = ? OR fa.co_pilot = ? OR fa.hostess = ? OR fa.co_hostess = ? OR fa.co_hostess_secondary = ?) 
    AND NOT EXISTS (
        SELECT 1
        FROM hotel_assign AS ha2
        WHERE ha2.did = ? AND ha2.id = fa.id
    )
);";

// Updated parameters to include the driver_id multiple times
$params = array(
    $driver_id, $driver_id, $driver_id, $driver_id, $driver_id,
    $driver_id, $driver_id, $driver_id, $driver_id, $driver_id,
    $driver_id, $driver_id, $driver_id, $driver_id, $driver_id,
    $driver_id, $driver_id // Add $driver_id again & again for the last parameter
);
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Fetch flight assignments into $data array
$data = array();
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $data[] = $row;
}

// Function to compare two rows based on 'flight_date' field
function compareDates($a, $b)
{
    $dateA = $a['flight_date'];
    $dateB = $b['flight_date'];

    if ($dateA == $dateB) {
        return 0;
    }

    return ($dateA < $dateB) ? 1 : -1;
}

// Sort the $data array by 'flight_date'
usort($data, 'compareDates');
?>

<link rel="stylesheet" href="./style/profile.css">
<div class="vw">
    <h2 class="hello">Welcome, <?php echo "<span class='driver_name'>" . $name; ?> </span></h2>

    <?php if (!empty($data)) : ?>

        <h3 class="table_title upcoming">Upcoming Flights:</h3>

        <table>
            <tr>
                <th>Flight ID</th>
                <th>Flight Date</th>
                <th>Flight From</th>
                <th>Flight To</th>
                <th>Role</th>
                <th>Hotel Name</th>
                <th>Hotel Room No</th>
                <th>Hotel Checkout Date</th>
            </tr>

            <?php
            $upcomingFlightsExist = false; // Initialize a variable to track upcoming flights 
            foreach ($data as $assignment) {
                if (strtotime($assignment['flight_date']->format('Y-m-d')) > strtotime(date('Y-m-d'))) {
                    $upcomingFlightsExist = true; // Set to true if there is an upcoming flight 
            ?>
                    <tr>
                        <td><?php echo $assignment['flight_id'] ?: '<span class="null">Error!</span>'; ?></td>
                        <td><?php echo $assignment['flight_date'] ? $assignment['flight_date']->format('Y-m-d') : '<span class="null">Error!</span>'; ?></td>
                        <td><?php echo $assignment['flight_from'] ?: '<span class="null">Error!</span>'; ?></td>
                        <td><?php echo $assignment['flight_to'] ?: '<span class="null">Error!</span>'; ?></td>
                        <td><?php echo $assignment['role'] ?: '<span class="null">Error!</span>'; ?></td>
                        <td><?php echo $assignment['hotel_name'] ?: '<span class="null">Not Assigned Yet</span>'; ?></td>
                        <td><?php echo $assignment['hotel_room_no'] ?: '<span class="null">Not Assigned Yet</span>'; ?></td>
                        <td><?php echo $assignment['hotel_checkout_date'] ? $assignment['hotel_checkout_date']->format('Y-m-d') : '<span class="null">Not Assigned Yet</span>'; ?></td>
                    </tr>
            <?php
                }
            }
            ?>
        </table>

        <?php if (!$upcomingFlightsExist) : ?>
            <p class="not_found">No upcoming flights found.</p>
        <?php endif; ?>

        <!-- Separate the table -->

        <h3 class="table_title previous">Previous Flights:</h3>
        <table>
            <tr>
                <th>Flight ID</th>
                <th>Flight Date</th>
                <th>Flight From</th>
                <th>Flight To</th>
                <th>Role</th>
                <th>Hotel Name</th>
                <th>Hotel Room No</th>
                <th>Hotel Checkout Date</th>
            </tr>

            <?php
            $upcomingFlightsExist = false; // Initialize a variable to track upcoming flights
            foreach ($data as $assignment) {
                if (strtotime($assignment['flight_date']->format('Y-m-d')) <= strtotime(date('Y-m-d'))) {
                    $upcomingFlightsExist = true; // Set to true if there is an upcoming flight 
            ?>
                    <tr>
                        <td><?php echo $assignment['flight_id'] ?: '<span class="null">Error!</span>'; ?></td>
                        <td><?php echo $assignment['flight_date'] ? $assignment['flight_date']->format('Y-m-d') : '<span class="null">Error!</span>'; ?></td>
                        <td><?php echo $assignment['flight_from'] ?: '<span class="null">Error!</span>'; ?></td>
                        <td><?php echo $assignment['flight_to'] ?: '<span class="null">Error!</span>'; ?></td>
                        <td><?php echo $assignment['role'] ?: '<span class="null">Error!</span>'; ?></td>
                        <td><?php echo $assignment['hotel_name'] ?: '<span class="null">Not Assigned Yet</span>'; ?></td>
                        <td><?php echo $assignment['hotel_room_no'] ?: '<span class="null">Not Assigned Yet</span>'; ?></td>
                        <td><?php echo $assignment['hotel_checkout_date'] ? $assignment['hotel_checkout_date']->format('Y-m-d') : '<span class="null">Not Assigned Yet</span>'; ?></td>
                    </tr>

            <?php
                }
            }
            ?>
        </table>

        <?php if (!$upcomingFlightsExist) : ?>
            <p class="not_found">No previous flight found.</p>
        <?php endif; ?>

    <?php else : ?>
        <p class="not_found">No flight assignments found.</p>
    <?php endif; ?>

</div>