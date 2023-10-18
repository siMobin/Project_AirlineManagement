<?php require_once('./mobile.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/side_bar.css">
    <title>Private jet/Admin</title>
</head>

<body>
    <!-- The sidebar -->
    <div class="sidebar">
        <!-- The logo -->
        <a class="logo" href="./schedule.php" <?php if (basename($_SERVER['PHP_SELF']) == 'schedule.php') echo 'class="active"'; ?>><i class="fa-solid fa-plane-lock"> private jet/Admin</i></a>
        <!-- The navigation links -->

        <div class="item">
            <a href="./validation.php" <?php if (basename($_SERVER['PHP_SELF']) == 'validation.php') echo 'class="active"'; ?>><i class="fas fa-check-circle"></i>Validation</a>
        </div>

        <div class="item">
            <a href="./schedule.php" <?php if (basename($_SERVER['PHP_SELF']) == 'schedule.php') echo 'class="active"'; ?>><i class="fas fa-clock"></i>Flight Schedule</a>
        </div>

        <div class="item"> <!-- assignment -->
            <a class="sub-btn"><i class="fas fa-plane"></i>Assignment<i class="fas fa-angle-right dropdown"></i></a>
            <div class="sub-menu">
                <a href="./flight_assign.php" <?php if (basename($_SERVER['PHP_SELF']) == 'flight_assign.php') echo 'class="active"'; ?>>Flight Assignment</a>
                <a href="./hotel_assign.php" <?php if (basename($_SERVER['PHP_SELF']) == 'hotel_assign.php') echo 'class="active"'; ?>>Hotel Assignment</a>
            </div>
        </div> <!-- end of assignment -->

        <div class="item"> <!-- driver and airport -->
            <a class="sub-btn"><i class="fas fa-map-marker-alt"></i>Driver and airport<i class="fas fa-angle-right dropdown"></i></a>
            <div class="sub-menu">
                <a href="./drivers.php" <?php if (basename($_SERVER['PHP_SELF']) == 'drivers.php') echo 'class="active"'; ?>>Drivers</a>
                <a href="./locations.php" <?php if (basename($_SERVER['PHP_SELF']) == 'locations.php') echo 'class="active"'; ?>>Airports</a>
            </div>
        </div> <!-- end of driver and airport -->

        <div class="item"> <!-- users -->
            <a class="sub-btn"><i class="fa-solid fa-user"></i>User<i class="fas fa-angle-right dropdown"></i></a>
            <div class="sub-menu">
                <a href="./users.php" <?php if (basename($_SERVER['PHP_SELF']) == 'users.php') echo 'class="active"'; ?>>Users</a>
                <a href="./search_user.php" <?php if (basename($_SERVER['PHP_SELF']) == 'search_user.php') echo 'class="active"'; ?>>Search Info.</a>
                <a href="./feedback_user.php" <?php if (basename($_SERVER['PHP_SELF']) == 'feedback_user.php') echo 'class="active"'; ?>>Feedback</a>
            </div>
        </div> <!-- end of users -->

        <div class="item">
            <a href="./stats.php" <?php if (basename($_SERVER['PHP_SELF']) == 'stats.php') echo 'class="active"'; ?>><i class="fas fa-chart-bar"></i>Stats</a>
        </div>


        <footer class="footer">
            <div class="marker">
                <a href="#">DSA ii Project</a>
                <a href="#">siMobin<span> · </span>Rahul</a>
            </div>
            <a class="logout" method="GET" href="?action=logout"><span>Logout </span><i class="fa-solid fa-right-from-bracket"></i></a>
        </footer>
    </div>

    <script src="./side_bar.js"></script>
</body>

</html>