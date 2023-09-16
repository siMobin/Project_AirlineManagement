<?php
require_once('./conn.php');

// variable for handel error
$report_empty_login_field = "";
$report_email_taken = "";
$report_user_name = "";
$report_user_name_taken = "";
$report_password = "";
$report_empty = "";

session_start(); //check if the user is already logged in
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    // User is logged in, redirect to the home page
    header("Location: ./=$username");
    exit;
}

//check if the user submitted the login form
if (isset($_POST["login"])) {
    //get the username and password from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    //validate the input
    if (empty($username) || empty($password)) {
        $report_empty_login_field = "<p class='report'>Please enter both username and password.</p>";
    } else {
        //prepare and execute the sql query to check if the user exists in the database
        $sql = "SELECT * FROM users WHERE username = ?";
        $params = array($username);
        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        //fetch the result
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        if ($row) {
            //verify the password
            if (password_verify($password, $row["password"])) {
                //set the session variable and redirect to the home page
                $_SESSION["username"] = $username;
                header("Location: ./=$username");
                exit;
            } else {
                $report_password = "<p class='report'>Incorrect password.</p>";
            }
        } else {
            $report_user_name = "<p class='report'>User not found</p>";
        }
    }
}

//check if the user submitted the registration form
if (isset($_POST["register"])) {
    //get the username, email and password from the form
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    //validate the input
    if (empty($username) || empty($email) || empty($password)) {
        $report_empty = "<p class='report'>Please enter email, username and password.</p>";
    } else {
        //prepare and execute the sql query to check if the username or email already exists in the database
        $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
        $params = array($username, $email);
        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        //fetch the result
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        if ($row) {
            //check which field is already taken
            if ($row["username"] == $username) {
                $report_user_name_taken = "<p class='report'>Username already taken.</p>";
            } else {
                $report_email_taken = "<p class='report'>Email already taken.</p>";
            }
        } else {
            //hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            //prepare and execute the sql query to insert the new user into the database
            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $params = array($username, $email, $hashed_password);
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

<html>

<head>
    <link rel="stylesheet" href="./style/login.css">
    <title>Login/Registration Form</title>
</head>

<body>
    <a href="./=?"><i class="fa-solid fa-plane-lock"> private jet</i></a>
    <div id="form">
        <div class="login">
            <h2>Login</h2>
            <hr>
            <form method="post" action="login.php">
                <h6>Username:</h6>
                <input type="text" name="username" required placeholder="User Name">
                <?php echo $report_user_name; ?>
                <h6>Password:</h6>
                <input type="password" name="password" required placeholder="password">
                <?php echo $report_password; ?>
                <?php echo $report_empty_login_field; ?>
                <br>
                <input class="submit" type="submit" name="login" value="Login">
            </form>
        </div>
        <hr class="center_hr">
        <div class="reg">
            <h2>Register</h2>
            <hr>
            <form method="post" action="login.php">
                <h6>Username:</h6>
                <input type="text" name="username" placeholder="User Name">
                <?php echo $report_user_name_taken; ?>
                <h6> Email:</h6>
                <input type="email" name="email" placeholder="you@gmail.com"><br />
                <?php echo $report_email_taken; ?>
                <h6>Password:</h6>
                <input type="password" name="password" placeholder="password">
                <?php echo $report_empty; ?>
                <br>
                <input class="submit" type="submit" name="register" value="Register">
            </form>
        </div>
    </div>
</body>

</html>