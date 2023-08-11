<?php
// for better performance Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    // exit;
}

$excluded_pages = array('bookings.php', 'profile.php'); //add all dashboard page!!!
if (!in_array(basename($_SERVER['PHP_SELF']), $excluded_pages)) {
    header("Location: ./bookings.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/dashboard.css">
</head>

<body>
    <div class="content">

        <!-- The navigation links -->
        <ul>
            <li><a href="./bookings.php" <?php if (basename($_SERVER['PHP_SELF']) == 'bookings.php') echo 'class="active"'; ?>><i class="fa-solid fa-plane-circle-check fa-sm"></i></a></li>
            <li><a href="./profile.php" <?php if (basename($_SERVER['PHP_SELF']) == 'profile.php') echo 'class="active"'; ?>><i class="fa-solid fa-user-secret"></i></a></li>
        </ul>
        <a class="logout" method="GET" href="?action=logout"><i class="fa-solid fa-right-from-bracket"></i></a>
    </div>
</body>

</html>