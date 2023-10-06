<?php
require_once('./conn.php');

// variables for error handling
$report_empty_login_field = "";
$report_email_taken = "";
$report_user_name = "";
$report_user_name_taken = "";
$report_password = "";
$report_empty = "";

session_start(); // check if the user is already logged in

if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    // User is logged in, redirect to the home page
    header("Location: ./=$username");
    exit;
}

// Check if the user submitted the login form
if (isset($_POST["login"])) {
    // Get the username, email/phone, and password from the form
    $username = $_POST["username"];
    $emailOrPhone = $_POST["EmailOrPhone"];
    $password = $_POST["password"];

    // Validate the input
    if (empty($username) || empty($emailOrPhone) || empty($password)) {
        $report_empty_login_field = "<p class='report'>Please enter username, email or phone, and password.</p>";
    } else {
        // Check if the input is a valid email
        if (filter_var($emailOrPhone, FILTER_VALIDATE_EMAIL)) {
            // The input is an email, so you can handle it accordingly
            // Prepare and execute the SQL query to check if the user exists in the database using the email
            $sql = "SELECT * FROM users WHERE (username = ? OR email = ?)";
            $params = array($username, $emailOrPhone);
        } else {
            // The input is not an email, so treat it as a phone number
            // Prepare and execute the SQL query to check if the user exists in the database using the phone number
            $sql = "SELECT * FROM users WHERE (username = ? OR phone = ?)";
            $params = array($username, $emailOrPhone);
        }

        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        // Fetch the result
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        if ($row) {
            // Verify the password
            if (password_verify($password, $row["password"])) {
                // Set the session variable and redirect to the home page
                $_SESSION["username"] = $row["username"];
                header("Location: ./?username={$row['username']}");
                exit;
            } else {
                $report_password = "<p class='report'>Incorrect password.</p>";
            }
        } else {
            $report_password = "<p class='report'>Incorrect username, email, phone, or password.</p>";
        }
    }
}




// check if the user submitted the registration form
if (isset($_POST["register"])) {
    // get the username, email, phone, and password from the form
    $username = $_POST["username"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];

    // validate the input
    if (empty($username) || empty($email) || empty($phone) || empty($password)) {
        $report_empty = "<p class='report'>Please enter email, username, phone, and password.</p>";
    } else {
        // Generate a 5-digit random "u_id"
        $u_id = mt_rand(10000, 99999);

        // Prepare and execute the SQL query to check if the username, email, or phone already exists in the database
        $sql = "SELECT * FROM users WHERE username = ? OR email = ? OR phone = ?";
        $params = array($username, $email, $phone);
        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        // Fetch the result
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        if ($row) {
            $report_empty = "<p class='report'>Username, email, or phone already taken.</p>";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare and execute the SQL query to insert the new user into the database with the generated "u_id"
            $sql = "INSERT INTO users (u_id, username, email, phone, password) VALUES (?, ?, ?, ?, ?)";
            $params = array($u_id, $username, $email, $phone, $hashed_password);
            $stmt = sqlsrv_query($conn, $sql, $params);
            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            //set the session variable and redirect to the home page
            $_SESSION["username"] = $username;
            header("Location: ./=$username");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./icon.ico">
    <link rel="stylesheet" href="./style/login.css">
    <title>Login/Registration Form</title>
</head>


<body>
    <a href="./"><i class="fa-solid fa-plane-lock"> private jet</i></a>
    <div id="form" title="Drag Me">

        <!-- Login form -->
        <div class="login">
            <h2>Login</h2>
            <hr>
            <form method="post" action="login.php" title="">
                <h6>Username</h6>
                <input type="text" name="username" required placeholder="Username">
                <?php echo $report_empty_login_field; ?>
                <h6>Email or Phone</h6>
                <input type="text" name="EmailOrPhone" required placeholder="Email or Phone"> <!-- Fix the field name here -->
                <?php echo $report_empty_login_field; ?>
                <h6>Password</h6>
                <input type="password" name="password" required placeholder="Password">
                <?php echo $report_password; ?>
                <br>
                <input class="submit" type="submit" name="login" value="Login">
            </form>
        </div>

        <hr class="center_hr">

        <!-- Registration form -->
        <div class="reg">
            <h2>Register</h2>
            <hr>
            <form method="post" action="login.php" title="">
                <h6>Username</h6>
                <input type="text" name="username" required placeholder="Username">
                <h6>Email</h6>
                <input type="email" name="email" required placeholder="you@gmail.com">
                <h6>Phone</h6>
                <input type="text" name="phone" required placeholder="Phone">
                <h6>Password</h6>
                <input type="password" name="password" required placeholder="Password">
                <?php echo $report_empty; ?>
                <br>
                <input class="submit" type="submit" name="register" value="Register">
            </form>
        </div>
    </div>

    <script src="./login.js"></script>

</body>

</html>