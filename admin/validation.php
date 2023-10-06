<?php require_once('./nav.php'); ?>
<?php require_once('./conn.php'); ?>
<?php include './side_bar.php' ?>
<?php require_once('./validation_search.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/validation.css">
</head>

<body>
    <h2>Today's flight</h2>
    <?php
    $currentDate = date('Y-m-d');
    $sqlCurrentBookings = "SELECT id, [from], [to], date, return_date, class, passengers, email, phone, trip, cost,confirm FROM bookings WHERE date = CONVERT(date, GETDATE()) UNION ALL SELECT id, [to], [from], return_date as date, return_date, class, passengers, email, phone, trip, cost,confirm FROM bookings WHERE return_date = CONVERT(date, GETDATE()) ORDER BY id";
    $stmtCurrentBookings = sqlsrv_query($conn, $sqlCurrentBookings);

    if ($stmtCurrentBookings === false) {
        die(print_r(sqlsrv_errors(), true)); // Handle error
    }

    while ($row = sqlsrv_fetch_array($stmtCurrentBookings, SQLSRV_FETCH_ASSOC)) {
        $FlightDate = $row['date']->format('Y-m-d');
        if ($FlightDate !== $currentDate) {
            continue; // Skip bookings not for the current date
        }
    ?>

        <div class="current-bookings">

            <table>
                <tr>
                    <th>ID</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Date</th>
                    <th>Class</th>
                    <th>Passengers</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Trip</th>
                    <th>Cost</th>
                    <th>Validity</th>
                    <th>Cancel Flight</th>
                </tr>
                <?php
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['from'] . "</td>";
                echo "<td>" . $row['to'] . "</td>";
                echo "<td>" . $FlightDate . "</td>";
                echo "<td>" . $row['class'] . "</td>";
                echo "<td>" . $row['passengers'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['phone'] . "</td>";
                echo "<td>" . $row['trip'] . "</td>";
                echo "<td>" . $row['cost'] . "</td>";
                echo "<td>";

                if ($row['confirm'] != NULL) {
                    // done
                    echo "The flight has already been confirmed!";
                    echo "<form method='post'>
                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                    
                    </form></td>";
                } else if ($FlightDate == date('Y-m-d')) {
                    // verify
                    echo "<form method='post'>
                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                    <input class='button' type='submit' name='confirm' value='✅'></td> <td>
                    <input class='cancel button' type='submit' name='cancel' value='❌'>
                    </form></td>";
                } else {
                    // cancel
                    echo "<form method='post'><input type='hidden' name='id' value='" . $row['id'] . "'><input class='empty' type='submit' name='confirm' value=''></td> <td><input class='cancel button' type='submit' name='cancel' value='❌'></form>";
                    echo "</tr>";
                }

                // Retrieve and display driver information from flight_assign
                $flightId = $row['id'];
                $sqlDriverInfo = "SELECT di.role AS driver_role, 
                                             CASE
                                                 WHEN fa.pilot = di.DID THEN 'Pilot'
                                                 WHEN fa.co_pilot = di.DID THEN 'co-Pilot'
                                                 WHEN fa.hostess = di.DID THEN 'Hostess'
                                                 WHEN fa.co_hostess = di.DID THEN 'co-Hostess'
                                                 WHEN fa.co_hostess_secondary = di.DID THEN 'co-Hostess-secondary'
                                                 ELSE 'Unknown'
                                             END AS driver_role,
                                             di.name AS driver_name
                                     FROM flight_assign fa
                                     INNER JOIN driver_info di ON fa.pilot = di.DID 
                                                            OR fa.co_pilot = di.DID
                                                            OR fa.hostess = di.DID 
                                                            OR fa.co_hostess = di.DID
                                                            OR fa.co_hostess_secondary = di.DID
                                     WHERE fa.id = ?";
                $paramsDriverInfo = array($flightId);
                $stmtDriverInfo = sqlsrv_query($conn, $sqlDriverInfo, $paramsDriverInfo);

                echo "<tr class='driver_row'>";
                echo "<th colspan='2'>Pilot</th>";
                echo "<th colspan='2'>co-Pilot</th>";
                echo "<th colspan='2'>Hostess</th>";
                echo "<th colspan='2'>co-Hostess</th>";
                echo "<th colspan='2'>co-Hostess-secondary</th>";
                echo "</tr>";

                echo "<tr class='driver-info-row'>";
                $driverRoles = array('Pilot', 'co-Pilot', 'Hostess', 'co-Hostess', 'co-Hostess-secondary');
                $driverNames = array_fill(0, 5, 'Not assigned yet'); // Initialize with default text

                while ($driverInfo = sqlsrv_fetch_array($stmtDriverInfo, SQLSRV_FETCH_ASSOC)) {
                    $driverRole = $driverInfo['driver_role'];
                    $driverName = $driverInfo['driver_name'];

                    $index = array_search($driverRole, $driverRoles);
                    if ($index !== false) {
                        $driverNames[$index] = $driverName;
                    }
                }

                foreach ($driverNames as $name) {
                    // Add a CSS class 'not-assigned' to cells with 'Not assigned yet'
                    $cssClass = ($name === 'Not assigned yet') ? 'not-assigned' : '';
                    echo "<td colspan='2' class='$cssClass driver_row'>" . $name . "</td>";
                }
                echo "</tr>";
                ?>
            </table>
        </div>

    <?php
    }
    ?>

    <?php
    // confirm/cancel button
    // confirm button
    if (isset($_POST['confirm'])) {
        $id = $_POST['id'];
        $sql = "UPDATE bookings SET confirm = 1 WHERE id = ?";
        $params = array($id);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            // header("Location: validation.php"); // control resubmission
            echo "<script>
            window.location.href = './validation.php';
            </script>";
            exit();
        }
    }
    // cancel button
    if (isset($_POST['cancel'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM bookings WHERE id = ?";
        $params = array($id);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            // header("Location: validation.php"); // control resubmission
            echo "<script>
            window.location.href = './validation.php';
            </script>";
            exit();
        }
    }
    ?>


</body>

</html>