<?php
require_once('./conn.php');

if (isLoggedIn()) {
    $username = $_SESSION["username"]; // Assuming you store username in the session
    // First, fetch the email based on the username
    $getEmailSql = "SELECT email FROM users WHERE username = ?";
    $getEmailParams = array($username);

    $getEmailStmt = sqlsrv_query($conn, $getEmailSql, $getEmailParams);

    if ($getEmailStmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($getEmailStmt, SQLSRV_FETCH_ASSOC);
    $email = $row['email'];

    // Now, retrieve booking information based on the email
    $getBookingSql = "SELECT b.id, b.[from], b.[to], b.date, b.return_date, b.class, b.passengers, b.trip, b.cost
                     FROM bookings AS b
                     WHERE b.email = ? order by date";
    $getBookingParams = array($email);

    $getBookingStmt = sqlsrv_query($conn, $getBookingSql, $getBookingParams);

    if ($getBookingStmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Info</title>
    <link rel="stylesheet" href="./style/bookings.css">
</head>

<body>
    <div class="dashboard">
        <?php require_once('./dashboard.php'); ?>
        <?php if (isLoggedIn()) : ?>
            <?php if ($getBookingStmt) : ?>
                <div class="user-info">
                    <h1>Your Booking Information</h1>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Date</th>
                            <th>Return Date</th>
                            <th>Class</th>
                            <th>Passengers</th>
                            <th>Trip</th>
                            <th>Cost</th>
                        </tr>
                        <?php while ($row = sqlsrv_fetch_array($getBookingStmt, SQLSRV_FETCH_ASSOC)) : ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['from']; ?></td>
                                <td><?php echo $row['to']; ?></td>
                                <td><?php echo $row['date'] ? $row['date']->format('Y-m-d') : 'N/A'; ?></td>
                                <td><?php echo $row['return_date'] ? $row['return_date']->format('Y-m-d') : 'N/A'; ?></td>
                                <td><?php echo $row['class']; ?></td>
                                <td><?php echo $row['passengers']; ?></td>
                                <td><?php echo $row['trip']; ?></td>
                                <td><?php echo $row['cost']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                </div>
            <?php else : ?>
                <p>Error executing the query: <?php echo print_r(sqlsrv_errors(), true); ?></p>
            <?php endif; ?>
        <?php else : ?>
            <p>Please log in to view your booking information.</p>
        <?php endif; ?>

        <?php
        sqlsrv_close($conn);
        ?>
    </div>
</body>

</html>