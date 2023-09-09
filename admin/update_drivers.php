<?php
include './nav.php';
require './conn.php';

// Check if a DID is provided in the URL
if (isset($_GET['did'])) {
    $didToUpdate = $_GET['did'];

    // Fetch driver data for the given DID from the driver_info table
    $sql = "SELECT * FROM driver_info WHERE DID = ?";
    $params = array($didToUpdate);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if (!$row) {
        // Handle the case where the DID is not found
        echo "Driver not found.";
        exit;
    }
}

// Check if the update form is submitted
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $did = $_POST['did']; // DID is fixed and unchangeable
    $role = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Check if the driver already exists in the driver table
    $sql_check = "SELECT COUNT(*) as count FROM driver WHERE DID = ?";
    $params_check = array($did);
    $stmt_check = sqlsrv_query($conn, $sql_check, $params_check);

    if ($stmt_check === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $row_check = sqlsrv_fetch_array($stmt_check, SQLSRV_FETCH_ASSOC);

    if ($row_check['count'] > 0) {
        // Update the driver table if it exists
        $sql_update_driver = "UPDATE driver SET name = ?, email = ?, phone = ? WHERE DID = ?";
        $params_update_driver = array($name, $email, $phone, $did);
        $stmt_update_driver = sqlsrv_query($conn, $sql_update_driver, $params_update_driver);

        if ($stmt_update_driver === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    }

    // Update the driver_info table
    $sql_update_info = "UPDATE driver_info SET name = ?, email = ?, phone = ?, role = ? WHERE DID = ?";
    $params_update_info = array($name, $email, $phone, $role, $did);
    $stmt_update_info = sqlsrv_query($conn, $sql_update_info, $params_update_info);

    if ($stmt_update_info === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Redirect back to the driver list page after a successful update
    header("Location: ./drivers.php");
    exit;
}

$sqlFlightHotelAssignments = "SELECT 
    fa.date AS flight_date, 
    b.[from] AS flight_from, 
    b.[to] AS flight_to, 
    ha.hotel AS hotel_name, 
    ha.room_no AS hotel_room_no, 
    ha.checkout_date AS hotel_checkout_date,
    fa.pilot AS pilot_role,
    fa.co_pilot AS co_pilot_role,
    fa.hostess AS hostess_role,
    fa.co_hostess AS co_hostess_role,
    fa.co_hostess_secondary AS co_hostess_secondary_role
FROM flight_assign AS fa 
LEFT JOIN hotel_assign AS ha ON fa.id = ha.id 
LEFT JOIN bookings AS b ON fa.id = b.id
WHERE (ha.did = ?)
UNION
SELECT 
    fa.date AS flight_date, 
    b.[from] AS flight_from, 
    b.[to] AS flight_to, 
    NULL AS hotel_name, 
    NULL AS hotel_room_no, 
    NULL AS hotel_checkout_date,
    fa.pilot AS pilot_role,
    fa.co_pilot AS co_pilot_role,
    fa.hostess AS hostess_role,
    fa.co_hostess AS co_hostess_role,
    fa.co_hostess_secondary AS co_hostess_secondary_role
FROM flight_assign AS fa 
LEFT JOIN bookings AS b ON fa.id = b.id
WHERE (
(fa.pilot = ? OR fa.co_pilot = ? OR fa.hostess = ? OR fa.co_hostess = ? OR fa.co_hostess_secondary = ?) 
AND NOT EXISTS (
    SELECT 1
    FROM hotel_assign AS ha2
    WHERE ha2.did = ? AND ha2.id = fa.id
));";

$params = array(
    $didToUpdate, $didToUpdate, $didToUpdate, $didToUpdate, $didToUpdate,
    $didToUpdate, $didToUpdate, $didToUpdate, $didToUpdate, $didToUpdate
);

$stmtFlightHotel = sqlsrv_query($conn, $sqlFlightHotelAssignments, $params);

if ($stmtFlightHotel === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include necessary styles and scripts here -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/update_drivers.css">
    <title>Edit Driver Information</title>
</head>

<body>
    <h1>Edit Driver Information</h1>
    <!-- Display DID and Name -->
    <div>
        <p>DID: <?php echo $row['DID']; ?></p>
        <p>Name: <?php echo $row['name']; ?></p>
        <p>Role: <?php echo $row['role']; ?></p>
    </div>
    <form method="post">
        <input type="hidden" name="did" value="<?php echo $row['DID']; ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required placeholder="Full Name" value="<?php echo $row['name']; ?>">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required placeholder="Email Address" value="<?php echo $row['email']; ?>">
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" required placeholder="Phone Number" value="<?php echo $row['phone']; ?>">
        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="pilot" <?php if ($row['role'] === 'pilot') echo 'selected'; ?>>Pilot</option>
            <option value="hostess" <?php if ($row['role'] === 'hostess') echo 'selected'; ?>>Hostess</option>
        </select>

        <input class="submit" type="submit" name="update" value="Update">
    </form>

    <!-- Display Flight and Hotel Assignment Statistics -->
    <h2>Flight and Hotel Assignment Statistics</h2>
    <table>
        <tr>
            <th>Flight Date</th>
            <th>Flight From</th>
            <th>Flight To</th>
            <th>Role</th>
            <th>Hotel Name</th>
            <th>Hotel Room No</th>
            <th>Hotel Checkout Date</th>
        </tr>
        <?php while ($assignment = sqlsrv_fetch_array($stmtFlightHotel, SQLSRV_FETCH_ASSOC)) { ?>
            <tr>
                <td><?php echo $assignment['flight_date'] ? $assignment['flight_date']->format('Y-m-d') : 'N/A'; ?></td>
                <td><?php echo $assignment['flight_from'] ? $assignment['flight_from'] : 'N/A'; ?></td>
                <td><?php echo $assignment['flight_to'] ? $assignment['flight_to'] : 'N/A'; ?></td>
                <td>
                    <?php
                    // Determine the role based on assignment columns
                    $role = '';
                    if ($assignment['pilot_role'] == $didToUpdate) {
                        $role = 'Pilot';
                    } elseif ($assignment['co_pilot_role'] == $didToUpdate) {
                        $role = 'Co-Pilot';
                    } elseif ($assignment['hostess_role'] == $didToUpdate) {
                        $role = 'Hostess';
                    } elseif ($assignment['co_hostess_role'] == $didToUpdate) {
                        $role = 'Co-Hostess';
                    } elseif ($assignment['co_hostess_secondary_role'] == $didToUpdate) {
                        $role = 'Co-Hostess (Secondary)';
                    }
                    echo $role ? $role : 'N/A';
                    ?>
                </td>
                <td><?php echo $assignment['hotel_name'] ? $assignment['hotel_name'] : 'N/A'; ?></td>
                <td><?php echo $assignment['hotel_room_no'] ? $assignment['hotel_room_no'] : 'N/A'; ?></td>
                <td><?php echo $assignment['hotel_checkout_date'] ? $assignment['hotel_checkout_date']->format('Y-m-d') : 'N/A'; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>