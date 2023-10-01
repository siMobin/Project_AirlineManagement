<?php include './nav.php'; ?>
<?php include './side_bar.php' ?>
<?php
require('./conn.php');

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $did = rand(10000, 99999);

    $sql = "INSERT INTO driver_info (DID, name, email, phone, role) VALUES (?, ?, ?, ?, ?)";
    $params = array($did, $name, $email, $phone, $role);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Redirect to a success page after successful form submission

    /*

    In the code below the 'header' drivers.php and the 'header' update_drivers.php conflicts with nav_marquee.php which returns an error when assigning a new pilot.
    To fix this issue javascript is used to redirect the page properly so this conflict may be avoided.
    
    */
    /*

    // Use JavaScript to redirect the page
    // header("Location: ./drivers.php");
    // or
    // header("Location: update_drivers.php?did=$did");

    */

    // Use PHP variable $did within JavaScript
    echo "
    <script>
        var did = " . json_encode($did) . ";
        window.location.href = 'update_drivers.php?did=' + did;
    </script>
    ";

    exit; // Make sure to exit to prevent further execution
}

if (isset($_POST['delete'])) {
    $didToDelete = $_POST['did'];

    $sql = "DELETE FROM driver_info WHERE DID = ?";
    $params = array($didToDelete);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}

// Get data for pilots
$sqlPilots = "SELECT * FROM driver_info WHERE role = 'pilot' ORDER BY name";
$stmtPilots = sqlsrv_query($conn, $sqlPilots);

if ($stmtPilots === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Get data for hostesses
$sqlHostesses = "SELECT * FROM driver_info WHERE role = 'hostess' ORDER BY name";
$stmtHostesses = sqlsrv_query($conn, $sqlHostesses);

if ($stmtHostesses === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/locations.css">
    <title>Driver Info Management</title>
</head>

<body>
    <h1>Add new driver</h1>
    <form method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required placeholder="Full Name">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required placeholder="Email Address">
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" required placeholder="Phone Number">
        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="pilot">Pilot</option>
            <option value="hostess">Hostess</option>
        </select>
        <input class="submit" type="submit" name="submit" value="Submit">
    </form>

    <h1>Pilot List</h1>
    <div class='table'>
        <table>
            <tr>
                <th>DID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Delete</th>
            </tr>
            <?php while ($row = sqlsrv_fetch_array($stmtPilots, SQLSRV_FETCH_ASSOC)) { ?>
                <tr class="driver_link" data-did="<?php echo $row['DID']; ?>" onclick="editDriver(<?php echo $row['DID']; ?>)">
                    <td><?php echo $row['DID']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td>
                        <form method='post'>
                            <input type='hidden' name='did' value='<?php echo $row['DID']; ?>'>
                            <button class='delete' type='submit' name='delete'><i class='fa fa-trash'></i></button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <h1>Hostess List</h1>
    <div class='table'>
        <table>
            <tr>
                <th>DID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Delete</th>
            </tr>
            <?php while ($row = sqlsrv_fetch_array($stmtHostesses, SQLSRV_FETCH_ASSOC)) { ?>
                <tr class="driver_link" data-did="<?php echo $row['DID']; ?>" onclick="editDriver(<?php echo $row['DID']; ?>)">
                    <td><?php echo $row['DID']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td>
                        <form method='post'>
                            <input type='hidden' name='did' value='<?php echo $row['DID']; ?>'>
                            <button class='delete' type='submit' name='delete'><i class='fa fa-trash'></i></button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <!-- driver stats -->
    <div class="chart">
        <div class="graph driver"> <?php include './driver_stats.php'; ?></div>
    </div>
    <script src="./driver_stats.js"></script>
    <script>
        // Function to redirect to the edit page with the DID parameter
        function editDriver(did) {
            window.location.href = 'update_drivers.php?did=' + did;
        }
    </script>
</body>

</html>