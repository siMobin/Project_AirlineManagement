<?php
//connect to sql server using windows authentication
$serverName = "ACER_LAPTOP\SQLEXPRESS"; //serverName\instanceName
$connectionInfo = array("Database" => "airline");
$conn = sqlsrv_connect($serverName, $connectionInfo);

if ($conn) {
    // echo "Connection established.<br />";
} else {
    echo "Connection could not be established.<br />";
    die(print_r(sqlsrv_errors(), true));
}

//check if the user is already logged in sent him a logout options
// session_start();
// if(isset($_SESSION["username"])){
//     echo "Welcome ".$_SESSION["username"]."<br />";
//     echo "<a href='../index.php'>Logout</a>";
//     exit;
// }

session_start(); //check if the user is already logged in
if (isset($_SESSION["username"])) {
    // User is logged in, redirect to the home page
    header("Location: ../home.php");
    exit;
}

//check if the user submitted the login form
if (isset($_POST["login"])) {
    //get the username and password from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    //validate the input
    if (empty($username) || empty($password)) {
        echo "<p class='report'>Please enter both username and password.</p> ";
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
                header("Location: ../home.php");
                exit;
            } else {
                echo "<p class='report'>Incorrect password.</p> ";
            }
        } else {
            echo "<p class='report'>User not found.</p> ";
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
        echo "<p class='report'>Please enter all the required fields.</p> ";
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
                echo "<p class='report'>Username already taken.</p> ";
            } else {
                echo "<p class='report'>Email already taken.</p> ";
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
            header("Location: index.php");
            exit;
        }
    }
}
?>

<html>

<head>
    <link rel="stylesheet" href="login.css">
    <title>Login/Registration Form</title>
</head>

<body>
    <a href="../home.php"><i class="fa-solid fa-plane-lock"> private jet</i></a>
    <div id="form">
        <div class="login">
            <h2>Login</h2>
            <hr>
            <form method="post" action="login.php">
                <h6>Username:</h6>
                <input type="text" name="username" placeholder="User Name">
                <h6>Password:</h6>
                <input type="password" name="password" placeholder="password"><br>
                <input class="submit" type="submit" name="login" value="Login">
            </form>
        </div>
        <hr>
        <div class="reg">
            <h2>Register</h2>
            <hr>
            <form method="post" action="login.php">
                <h6>Username:</h6>
                <input type="text" name="username" placeholder="User Name"><br />
                <h6> Email:</h6>
                <input type="email" name="email" placeholder="you@gmail.com"><br />
                <h6>Password:</h6>
                <input type="password" name="password" placeholder="password"><br />
                <input class="submit" type="submit" name="register" value="Register">
            </form>
        </div>
    </div>
</body>

</html>