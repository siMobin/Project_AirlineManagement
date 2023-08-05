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
            <li><a href="./schedule.php" <?php if (basename($_SERVER['PHP_SELF']) == 'schedule.php') echo 'class="active"'; ?>>Flight Schedule</a></li>
            <li><a href="./temp.php" <?php if (basename($_SERVER['PHP_SELF']) == 'temp.php') echo 'class="active"'; ?>>Page 2</a></li>
            <li><a href="page3.php" <?php if (basename($_SERVER['PHP_SELF']) == 'page3.php') echo 'class="active"'; ?>>Page 3</a></li>
            <li class="logout"> <a method="GET" href="?action=logout">Logout</a></li>
        </ul>
    </nav>

</body>

</html>