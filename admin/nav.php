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

require_once('./mobile.php');
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
        <a class="logout" method="GET" href="?action=logout">Logout</a>
    </nav>
</body>

</html>