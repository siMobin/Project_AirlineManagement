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
            <a href="./validation.php" <?php if (basename($_SERVER['PHP_SELF']) == 'validation.php') echo 'class="active"'; ?>>Validation</a>
        </div>

        <div class="item">
            <a href="./schedule.php" <?php if (basename($_SERVER['PHP_SELF']) == 'schedule.php') echo 'class="active"'; ?>>Flight Schedule</a>
        </div>

        <div class="item"> <!-- assignment -->
            <a class="sub-btn">Assignment<i class="fas fa-angle-right dropdown"></i></a>
            <div class="sub-menu">
                <a href="./flight_assign.php" <?php if (basename($_SERVER['PHP_SELF']) == 'flight_assign.php') echo 'class="active"'; ?>>Flight Assignment</a>
                <a href="./hotel_assign.php" <?php if (basename($_SERVER['PHP_SELF']) == 'hotel_assign.php') echo 'class="active"'; ?>>Hotel Assignment</a>
            </div>
        </div> <!-- end of assignment -->

        <div class="item"> <!-- driver and airport -->
            <a class="sub-btn">Driver and airport<i class="fas fa-angle-right dropdown"></i></a>
            <div class="sub-menu">
                <a href="./drivers.php" <?php if (basename($_SERVER['PHP_SELF']) == 'drivers.php') echo 'class="active"'; ?>>Drivers</a>
                <a href="./locations.php" <?php if (basename($_SERVER['PHP_SELF']) == 'locations.php') echo 'class="active"'; ?>>Airports</a>
            </div>
        </div> <!-- end of driver and airport -->

        <div class="item">
            <a href="./stats.php" <?php if (basename($_SERVER['PHP_SELF']) == 'stats.php') echo 'class="active"'; ?>>Stats</a>
        </div>


        <footer>
            <div class="marker">
                <a href="#">DSA ii Project</a>
                <a href="#">siMobin<span> · </span>Rahul</a>
            </div>
            <a class="logout" method="GET" href="?action=logout"><span>Logout </span><i class="fa-solid fa-right-from-bracket"></i></a>
        </footer>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <script src="./side_bar.js"></script>
</body>

</html>