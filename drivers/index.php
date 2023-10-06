<?php
session_start(); // Start the session
if (isset($_SESSION["driver_id"])) {
    $did_s = $_SESSION["driver_id"];
    // driver is logged in, redirect to the home page
    header("Location: ./profile.php?did=$did_s");
    exit;
}
require('./conn.php');

$insert_warning = "";
$warning_name_login = ""; // Define warning variable for name not found in login
$warning_pass = ""; // Define warning variable for invalid password in login
$warning_name_register = ""; // Define warning variable for name not found in registration

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["register"])) {
        $did = $_POST["did"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        // Check if DID, email, or phone match in driver_info table
        $query = "SELECT DID, name FROM driver_info WHERE DID = ? AND email = ? AND phone = ?";
        $params = array($did, $email, $phone);
        $stmt = sqlsrv_query($conn, $query, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        if (sqlsrv_has_rows($stmt)) {
            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            $name = $row["name"];

            // Insert new driver into driver table
            $query = "INSERT INTO driver (DID, name, email, phone, password) VALUES (?, ?, ?, ?, ?)";
            $params = array($did, $name, $email, $phone, $password);
            $stmt = sqlsrv_query($conn, $query, $params);

            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
                $insert_warning = "Registration failed!/Server error";
            } else {
                // Get the newly inserted driver's DID
                $query = "SELECT DID FROM driver WHERE email = ?";
                $params = array($email);
                $stmt = sqlsrv_query($conn, $query, $params);

                if ($stmt === false) {
                    die(print_r(sqlsrv_errors(), true));
                    $insert_warning = "Registration failed!/Server error";
                }

                $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
                $driver_id = $row["DID"];

                // Set the session variable
                $_SESSION["driver_id"] = $driver_id;

                // Registration successful - redirect to the profile page
                header("Location: ./profile.php?$email");
                exit(); // Make sure to exit after redirection
            }
        } else {
            $warning_name_register = "DID/Email/Phone not found!";
        }
    }


    if (isset($_POST["login"])) {
        $did = $_POST["did"];
        $emailOrPhone = $_POST["email_phone"];
        $password = $_POST["password"];

        // Check if email, phone, or DID exists in driver table
        $query = "SELECT DID, password FROM driver WHERE DID = ? AND (email = ? OR phone = ?)";
        $params = array($did, $emailOrPhone, $emailOrPhone);
        $stmt = sqlsrv_query($conn, $query, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        if (sqlsrv_has_rows($stmt)) {
            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            if (password_verify($password, $row["password"])) {
                // Successful login, set driver ID in session and redirect to profile.php
                $_SESSION["driver_id"] = $row["DID"];
                header("Location: ./profile.php?$emailOrPhone");
                exit();
            } else {
                // echo "Login failed. Invalid password.";
                $warning_pass = "Invalid password!";
            }
        } else {
            // echo "Login failed. DID/Email/Phone not found.";
            $warning_name_login = "DID/Email or Phone not match!";
        }
    }
}
sqlsrv_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Login and Registration</title>
    <link rel="icon" type="image/x-icon" href="./icon.ico">
    <link rel="stylesheet" href="./style/driver_login.css">
</head>

<body>
    <div id="form">
        <div class="login">
            <h2>Login</h2>
            <form method="post" action="">

                <div>
                    <h1>DID:</h1>
                    <input type="text" name="did" required placeholder="DID">
                </div>
                <div>
                    <h1>Email/Phone:</h1>
                    <input type="text" name="email_phone" required placeholder="email or phone number">
                </div>
                <div class="warning"><?php echo $warning_name_login; ?></div>
                <div>
                    <h1>Password:</h1>
                    <input type="password" name="password" required placeholder="password">
                </div>
                <div class="warning"><?php echo $warning_pass; ?></div>
                <div>
                    <input class="submit" type="submit" name="login" value="Login">
                </div>
            </form>
        </div>

        <hr>

        <div class="reg">
            <h2>Registration</h2>
            <form method="post" action="">
                <div class="warning"><?php echo $insert_warning; ?></div>
                <div>
                    <h1>DID:</h1>
                    <input type="text" name="did" required placeholder="DID">
                </div>
                <div>
                    <h1> Email:</h1>
                    <input type="email" name="email" required placeholder="you@gmail.com">
                </div>
                <div>
                    <h1>Phone:</h1>
                    <input type="text" name="phone" required placeholder="phone">
                </div>
                <div class="warning"><?php echo $warning_name_register; ?></div>
                <div>
                    <h1>Password:</h1>
                    <input type="password" name="password" required placeholder="password">
                </div>
                <div>
                    <input class="submit" type="submit" name="register" value="Register">
                </div>
            </form>
        </div>
    </div>
</body>

</html>