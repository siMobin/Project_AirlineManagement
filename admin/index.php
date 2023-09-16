<?php
require('./conn.php');

// $admin="";
session_start();
// Check if the admin_name session variable is set
// $admin_name = $_SESSION["admin_name"];
if (isset($_SESSION['admin_name'])) {
    // The admin is not logged in, redirect to the login page
    header("Location: ./schedule.php");
    exit;
}

$warning = "";

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Get the submitted admin_name and password
    $admin_name = $_POST['admin_name'];
    $password = $_POST['password'];

    // Prepare a parameterized query to check if the admin_name and password are correct
    $query = "SELECT * FROM admin_login WHERE admin_name=? AND password=?";
    $params = array($admin_name, $password);
    $result = sqlsrv_query($conn, $query, $params);

    // Check if a row was returned, meaning the login was successful
    if (sqlsrv_has_rows($result)) {
        // Start a session and store the admin_name
        session_start();
        $_SESSION['admin_name'] = $admin_name;

        // Redirect to the admin dashboard
        header("Location: ./schedule.php");
        exit;
    } else {
        // Login failed, display an error message
        $warning = "<p class='warning'>Invalid username or password</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/admin_login.css">
    <title>Login</title>
</head>

<body>
    <!-- The login form -->
    <form method="post">
        <label for="admin_name">Name of Administrator:</label>
        <input type="text" name="admin_name" id="admin_name" placeholder="Admin" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="password" required>
        <?php echo $warning; ?><br>
        <input class="submit" type="submit" name="submit" value="Login">
    </form>
</body>

</html>