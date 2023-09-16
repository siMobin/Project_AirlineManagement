<?php
session_start();
// Check if the admin_name session variable is set
if (!isset($_SESSION['driver_id'])) {
    // The admin is not logged in, redirect to the login page
    header("Location: ./?login");
    exit;
} else {
    $excluded_pages = array('profile.php'); //add all page to redirect profile!!!
    if (!in_array(basename($_SERVER['PHP_SELF']), $excluded_pages)) {
        header("Location: ./profile.php");
    }
}

// Check if the logout link was clicked
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logout();
}

// Logout the admin
function logout()
{
    session_destroy();
    header("Location: ./?login");
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
            <li><a href="./flight_assign.php" <?php if (basename($_SERVER['PHP_SELF']) == 'flight_assign.php') echo 'class="active"'; ?>>Flight Assignment</a></li>
            <li><a href="./schedule.php" <?php if (basename($_SERVER['PHP_SELF']) == 'schedule.php') echo 'class="active"'; ?>>Flight Schedule</a></li>
            <li><a href="./drivers.php" <?php if (basename($_SERVER['PHP_SELF']) == 'drivers.php') echo 'class="active"'; ?>>Drivers</a></li>
            <li><a href="./locations.php" <?php if (basename($_SERVER['PHP_SELF']) == 'locations.php') echo 'class="active"'; ?>>Airport</a></li>
            <li><a href="./stats.php" <?php if (basename($_SERVER['PHP_SELF']) == 'stats.php') echo 'class="active"'; ?>>Stats</a></li>
            <li class="logout"> <a method="GET" href="?action=logout">Logout</a></li>
        </ul>
    </nav>

</body>

</html>