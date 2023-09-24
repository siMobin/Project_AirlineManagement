<?php
session_start();
// Check if the admin_name session variable is set
if (!isset($_SESSION['admin_name'])) {
    // The admin is not logged in, redirect to the login page
    header("Location: ./login=?");
    exit;
}

// Check if the logout link was clicked
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logout();
}

// Logout the admin
function logout()
{
    // session_destroy();
    unset($_SESSION['admin_name']);
    header("Location: ./login=?");
    exit;
}

require_once('./mobile.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./icon.ico">
    <link rel="stylesheet" href="./style/nav.css">
    <title>Private jet/Admin</title>
</head>

<body>
    <nav>
        <div class="scroll">
            <?php include "nav_marquee.php"; ?>
        </div>
        <a class="logout" method="GET" href="?action=logout">Logout</a>
    </nav>
</body>

</html>