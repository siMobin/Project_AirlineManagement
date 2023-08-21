<?php
session_start();
// Check if the admin_name session variable is set
if (!isset($_SESSION['username'])) {
    // The admin is not logged in, redirect to the login page
    header("Location: ./admin_login.php");
    exit;
}

// Check if the logout link was clicked
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logout();
}

// Logout the admin
function logout()
{
    session_destroy();
    header("Location: ./admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/nav.css">
    <title>Private jet/Admin</title>
</head>

<body>
    <!-- The navigation bar -->
    <nav>
        <!-- The logo -->
        <a class="logo" href="index.php"><i class="fa-solid fa-plane-lock"> private jet/Admin</i></a>
        <!-- The navigation links -->
        <ul>
            <li><a href="./validation.php" <?php if (basename($_SERVER['PHP_SELF']) == 'validation.php') echo 'class="active"'; ?>>Validation</a></li>
            <!-- assignment -->
            <li class="dropdown">
                <a href="javascript:void(0);" class="dropbtn">
                    <?php
                    $assignmentActive = basename($_SERVER['PHP_SELF']) == 'flight_assign.php' || basename($_SERVER['PHP_SELF']) == 'hotel_assign.php';
                    if ($assignmentActive) {
                        if (basename($_SERVER['PHP_SELF']) == 'flight_assign.php') {
                            echo "<span class='active'>Flight Assignment<span>";
                        } elseif (basename($_SERVER['PHP_SELF']) == 'hotel_assign.php') {
                            echo "<span class='active'>Hotel Assignment<span>";
                        }
                    } else {
                        echo 'Assignment';
                    }
                    ?>
                    <i class="fa-solid fa-caret-down"></i>
                </a>
                <div class="dropdown-content">
                    <a href="./flight_assign.php" <?php if (basename($_SERVER['PHP_SELF']) == 'flight_assign.php') echo 'class="active"'; ?>>Flight Assignment</a>
                    <a href="./hotel_assign.php" <?php if (basename($_SERVER['PHP_SELF']) == 'hotel_assign.php') echo 'class="active"'; ?>>Hotel Assignment</a>
                </div>
            </li>
            <!-- end of assignment -->

            <!-- driver and airport -->
            <li class="dropdown">
                <a href="javascript:void(0);" class="dropbtn">
                    <?php
                    $assignmentActive = basename($_SERVER['PHP_SELF']) == 'drivers.php' || basename($_SERVER['PHP_SELF']) == 'locations.php';
                    if ($assignmentActive) {
                        if (basename($_SERVER['PHP_SELF']) == 'drivers.php') {
                            echo "<span class='active'>Drivers<span>";
                        } elseif (basename($_SERVER['PHP_SELF']) == 'locations.php') {
                            echo "<span class='active'>Airports<span>";
                        }
                    } else {
                        echo 'Assignment';
                    }
                    ?>
                    <i class="fa-solid fa-caret-down"></i>
                </a>
                <div class="dropdown-content">
                    <a href="./drivers.php" <?php if (basename($_SERVER['PHP_SELF']) == 'drivers.php') echo 'class="active"'; ?>>Drivers</a>
                    <a href="./locations.php" <?php if (basename($_SERVER['PHP_SELF']) == 'locations.php') echo 'class="active"'; ?>>Airports</a>
                </div>
            </li>
            <!-- end of driver and airport -->
            <li><a href="./schedule.php" <?php if (basename($_SERVER['PHP_SELF']) == 'schedule.php') echo 'class="active"'; ?>>Flight Schedule</a></li>
            <li><a href="./stats.php" <?php if (basename($_SERVER['PHP_SELF']) == 'stats.php') echo 'class="active"'; ?>>Stats</a></li>
            <li class="logout"> <a method="GET" href="?action=logout">Logout</a></li>
        </ul>
    </nav>

</body>

</html>