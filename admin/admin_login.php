<?php
require('./conn.php');

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Get the submitted username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare a parameterized query to check if the username and password are correct
    $query = "SELECT * FROM admin_login WHERE username=? AND password=?";
    $params = array($username, $password);
    $result = sqlsrv_query($conn, $query, $params);

    // Check if a row was returned, meaning the login was successful
    if (sqlsrv_has_rows($result)) {
        // Start a session and store the username
        session_start();
        $_SESSION['username'] = $username;

        // Redirect to the admin dashboard
        header("Location: ./schedule.php");
        exit;
    } else {
        // Login failed, display an error message
        echo "<p class='warning'>Invalid username or password</p>";
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
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" placeholder="Admin" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="password" required>
        <br>
        <input class="submit" type="submit" name="submit" value="Login">
    </form>
</body>

</html>