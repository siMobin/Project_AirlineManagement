<?php include './nav.php'; ?>
<?php include './side_bar.php' ?>

<link rel="stylesheet" href="./style/users.css">

<!-- just for some space -->
<div id="users">

    <?php
    require './conn.php';

    // Query to retrieve user information and the total number of booked flights
    $query = "SELECT users.*, ISNULL(total_bookings, 0) AS total_bookings FROM users
        LEFT JOIN (
            SELECT email, COUNT(*) AS total_bookings FROM bookings
            GROUP BY email
        ) AS booking_counts
        ON users.email = booking_counts.email order by U_ID;";

    // Execute the query
    $result = sqlsrv_query($conn, $query);

    // Check for errors
    if (!$result) {
        echo "Error: " . print_r(sqlsrv_errors(), true);
    } else {
        echo "<h1>User Information</h1>";
        echo "<table>";
        echo "<tr>";
        echo "<th>User ID</th>";
        echo "<th>Username</th>";
        echo "<th>Email</th>";
        echo "<th>Phone</th>";
        echo "<th>Total Booked Flights</th>";
        echo "</tr>";

        // Loop through all user records and display information in a table
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['U_ID'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['phone'] . "</td>";
            echo "<td>" . $row['total_bookings'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    // Close the database connection
    sqlsrv_close($conn);
    ?>
</div>