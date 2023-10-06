<?php require_once('./nav.php'); ?>
<?php include './side_bar.php' ?>
<?php require_once('./conn.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/hotel_assign.css">
    <title>Document</title>
</head>

<body>

    <div class="block">
        <?php
        function compareDates($a, $b)
        {
            return strcmp($a['date'], $b['date']);
        }
        // Function to check if a booking ID exists in the hotel_assign table
        function bookingExistsInHotelAssign($booking_id, $conn)
        {
            $sql = "SELECT COUNT(*) AS count FROM hotel_assign WHERE id = ?";
            $params = array($booking_id);

            $stmt = sqlsrv_query($conn, $sql, $params);
            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            return $row['count'] > 0;
        }


        // Retrieve booking IDs and corresponding check-in dates
        $bookings = array();
        $sql = "SELECT id, date FROM flight_assign";
        $result = sqlsrv_query($conn, $sql);
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $bookings[] = array(
                'id' => $row["id"],
                'date' => $row["date"]->format('Y-m-d')
            );
        }
        usort($bookings, 'compareDates');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            foreach ($_POST as $key => $value) {
                if (strpos($key, "checkout_date_") === 0) {
                    $id = substr($key, strlen("checkout_date_"));
                    $checkout_date = new DateTime($value);
                    $checkout_date_string = $checkout_date->format('Y-m-d');
                    $roles = array("pilot", "co_pilot", "hostess", "co_hostess", "co_hostess_secondary");

                    foreach ($roles as $role) {
                        $room_no = $_POST["{$role}_room_$id"];
                        $sql = "INSERT INTO hotel_assign (id, did, role, checkin_date, checkout_date, room_no, hotel)
                            VALUES (?, ?, ?, ?, ?, ?, ?)";
                        $params = array(
                            $id,
                            getDriverDID($id, $role, $conn),
                            $role,
                            getCheckinDate($id, $conn),
                            $checkout_date_string,
                            $room_no,
                            $_POST["hotel_name_$id"] // Use the posted hotel name
                        );

                        $stmt = sqlsrv_query($conn, $sql, $params);

                        if (!$stmt) {
                            die(print_r(sqlsrv_errors(), true));
                        }
                    }
                }
            }
            // Redirect back to the form page with a success message
            // header("Location: hotel_assign.php?success=!");
            echo "<script>
            window.location.href = './hotel_assign.php';
            alert('Success!');
            </script>";
            exit();
        }

        // Function to retrieve the check-in date for a given booking ID
        function getCheckinDate($booking_id, $conn)
        {
            $sql = "SELECT date FROM flight_assign WHERE id = ?";
            $params = array($booking_id);

            $stmt = sqlsrv_query($conn, $sql, $params);
            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            $checkin_date = $row["date"];

            return $checkin_date;
        }

        // Function to retrieve the "to" location name for a given booking ID
        function getToLocation($booking_id, $conn)
        {
            $sql = "SELECT [to] FROM bookings WHERE id = ?";
            $params = array($booking_id);

            $stmt = sqlsrv_query($conn, $sql, $params);
            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            $to_location = $row["to"];

            return $to_location;
        }

        // Function to retrieve the corresponding DID for a driver role
        function getDriverDID($booking_id, $driver_role, $conn)
        {
            $sql = "SELECT $driver_role FROM flight_assign WHERE id = ?";
            $params = array($booking_id);

            $stmt = sqlsrv_query($conn, $sql, $params);
            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            return $row[$driver_role];
        }

        // Function to retrieve the hotel name for a given booking ID
        function getHotelForBooking($booking_id, $conn)
        {
            $sql = "SELECT [to] FROM bookings WHERE id = ?";
            $params = array($booking_id);

            $stmt = sqlsrv_query($conn, $sql, $params);
            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            $destination = $row["to"];

            return getHotelNameForDestination($destination, $conn);
        }

        // Function to retrieve the hotel name for a given destination
        function getHotelNameForDestination($destination, $conn)
        {
            $sql = "SELECT hotel FROM locations WHERE destination = ?";
            $params = array($destination);

            $stmt = sqlsrv_query($conn, $sql, $params);
            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            return $row["hotel"];
        }

        // Generate HTML content for each booking
        foreach ($bookings as $booking) {
            $id = $booking['id'];
            // Skip booking ID if it already exists in hotel_assign
            if (bookingExistsInHotelAssign($id, $conn)) {
                continue;
            }

            // Check if the 'hostess', 'co_hostess', and 'co_hostess_secondary' columns have a value of 0
            $sql_check_zero_values = "SELECT hostess, co_hostess, co_hostess_secondary FROM flight_assign WHERE id = ?";
            $params_check_zero_values = array($id);
            $stmt_check_zero_values = sqlsrv_query($conn, $sql_check_zero_values, $params_check_zero_values);
            if ($stmt_check_zero_values === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            // Fetch the result
            $zeroValuesRow = sqlsrv_fetch_array($stmt_check_zero_values, SQLSRV_FETCH_ASSOC);

            // Generate and display the input boxes conditionally
            $hotel_name = getHotelForBooking($id, $conn);
            $to_location = getToLocation($id, $conn);
            echo "<div class='wrap'>";
            echo "<h2>Booking ID: $id</h2>
          <form method='POST'>
            <p>Airport Location: $to_location</p>
            <p>Check-in Date: {$booking['date']}</p>";

            // hotel name
            echo "<div class='box'>
            <label for='hotel_name_$id'>Hotel Name:</label>
            <input type='text' name='hotel_name_$id' value='$hotel_name' required>
    </div>";

            // checkout date
            echo "<div class='box'>
            <label for='checkout_date_$id'>Checkout Date:</label>
            <input type='date' name='checkout_date_$id' required>
    </div>";

            // room number
            $roles = array("pilot", "co_pilot", "hostess", "co_hostess", "co_hostess_secondary");
            foreach ($roles as $role) {
                // Check if the current role is 'hostess', 'co_hostess', or 'co_hostess_secondary' and if its corresponding value is 0
                if (($role === 'hostess' || $role === 'co_hostess' || $role === 'co_hostess_secondary') && $zeroValuesRow[$role] === 0) {
                    continue; // Skip this input field if the value is 0
                }

                echo "<div class='box'>
                <label for='{$role}_room_$id'>Room Number for $role:</label>
                <input type='text' name='{$role}_room_$id' placeholder='room no. for $role'>
        </div>";
            }

            // submit button
            echo "<button class='submit' type='submit' name='assign_$id'>Assign</button>";
            echo "</form></div>";
        }
        sqlsrv_close($conn);
        ?>
    </div>
</body>

</html>