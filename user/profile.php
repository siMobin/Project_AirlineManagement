<?php
require_once('./conn.php');

// Retrieve user information from the database
$userInfo = array();
$sql = "SELECT U_ID, username, email, phone FROM users WHERE username = ?";
$params = array($_SESSION['username']);
$result = sqlsrv_query($conn, $sql, $params);

if ($result && sqlsrv_has_rows($result)) {
    $userInfo = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
}

// Check if update username form was submitted
if (isset($_POST['updateUsername'])) {
    // Get new username from form
    $newUsername = $_POST['newUsername'];

    // Update users table with new username
    $sql = "UPDATE users SET username = ? WHERE username = ?";
    $params = array($newUsername, $_SESSION['username']);
    sqlsrv_query($conn, $sql, $params);

    // Update session with new username
    $_SESSION['username'] = $newUsername;
}

// Check if update password form was submitted
if (isset($_POST['updatePassword'])) {
    // Get new password from form
    $newPassword = $_POST['newPassword'];

    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update users table with hashed password
    $sql = "UPDATE users SET password = ? WHERE username = ?";
    $params = array($hashedPassword, $_SESSION['username']);
    sqlsrv_query($conn, $sql, $params);
}

// Check if update email form was submitted
if (isset($_POST['updateEmail'])) {
    // Get new email from form
    $newEmail = $_POST['newEmail'];

    // Update users table with new email
    $sql = "UPDATE users SET email = ? WHERE username = ?";
    $params = array($newEmail, $_SESSION['username']);
    sqlsrv_query($conn, $sql, $params);
    $userInfo['email'] = $newEmail; // Update displayed email
}

// Check if update phone form was submitted
if (isset($_POST['updatePhone'])) {
    // Get new phone from form
    $newPhone = $_POST['newPhone'];

    // Update users table with new phone
    $sql = "UPDATE users SET phone = ? WHERE username = ?";
    $params = array($newPhone, $_SESSION['username']);
    sqlsrv_query($conn, $sql, $params);
    $userInfo['phone'] = $newPhone; // Update displayed phone number
}

// Check if delete button was clicked
if (isset($_POST['delete'])) {
    // Delete user record from users table
    $sql = "DELETE FROM users WHERE username = ?";
    $params = array($_SESSION['username']);
    sqlsrv_query($conn, $sql, $params);

    // Log out user and redirect to login page
    session_destroy();
    header("Location: ./login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="./style/profile.css">
</head>

<body>
    <div class="dashboard">
        <?php require_once('./dashboard.php'); ?>

        <div class="container">
            <h1>Your Profile</h1>

            <!-- Display user information -->
            <p><strong>User ID:</strong> <?php echo $userInfo['U_ID']; ?></p>
            <p><strong>User name:</strong> <?php echo $userInfo['username']; ?></p>
            <p><strong>Email:</strong> <?php echo $userInfo['email']; ?></p>
            <p><strong>Phone:</strong> <?php echo $userInfo['phone']; ?></p>

            <!-- Update username form -->
            <form action="" method="post">
                <label for="newUsername">New Username:</label>
                <input type="text" id="newUsername" name="newUsername" required placeholder="Name">
                <button class="submit" type="submit" name="updateUsername">Change</button>
            </form>



            <!-- Update email form -->
            <form action="" method="post">
                <label for="newEmail">New Email:</label>
                <input type="email" id="newEmail" name="newEmail" required placeholder="Email">
                <button class="submit" type="submit" name="updateEmail">Change</button>
            </form>

            <!-- Update phone form -->
            <form action="" method="post">
                <label for="newPhone">New Phone:</label>
                <input type="text" id="newPhone" name="newPhone" required placeholder="Phone">
                <button class="submit" type="submit" name="updatePhone">Change</button>
            </form>

            <!-- Update password form -->
            <form action="" method="post">
                <label for="newPassword">New Password:</label>
                <input type="password" id="newPassword" name="newPassword" required placeholder="password">
                <button class="submit" type="submit" name="updatePassword">Change</button>
            </form>

            <!-- Delete account form -->
            <form action="" method="post">
                <button class="delete submit" type="submit" name="delete">Delete Account</button>
            </form>
        </div>
    </div>
</body>

</html>