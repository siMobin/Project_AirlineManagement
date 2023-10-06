<?php
session_start();
// Check if the admin_name session variable is set
if (!isset($_SESSION['driver_id'])) {
    // The admin is not logged in, redirect to the login page
    header("Location: ./login=?");
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
    // session_destroy();
    unset($_SESSION['driver_id']);
    header("Location: ./login=?");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./icon.ico">
    <link rel="stylesheet" href="./style/nav.css">
    <title>Private jet/Drivers</title>
</head>

<body>
    <!-- The navigation bar -->
    <nav>
        <!-- The logo -->
        <a class="logo" href="index.php"><i class="fa-solid fa-plane-lock"><span> <!-- dynamically hide large logo when in mobile device --></span></i></a>
        <!-- The navigation links -->
        <ul>
            <li><a href="./profile.php" <?php if (basename($_SERVER['PHP_SELF']) == 'profile.php') echo 'class="active"'; ?>>Home</a></li>
            <li><a href="./#.php" <?php if (basename($_SERVER['PHP_SELF']) == '#.php') echo 'class="active"'; ?>>Info</a></li>

            <!-- logout -->
            <li class="logout"> <a method="GET" href="?action=logout">Logout</a></li>
        </ul>
    </nav>

</body>

</html>