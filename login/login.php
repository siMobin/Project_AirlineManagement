<?php
//connect to sql server using windows authentication
$serverName = "ACER_LAPTOP\SQLEXPRESS"; //serverName\instanceName
$connectionInfo = array( "Database"=>"airline");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
     echo "Connection established.<br />";
}else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}

//check if the user is already logged in sent him a logout options
// session_start();
// if(isset($_SESSION["username"])){
//     echo "Welcome ".$_SESSION["username"]."<br />";
//     echo "<a href='../index.php'>Logout</a>";
//     exit;
// }

session_start();//check if the user is already logged in
if(isset($_SESSION["username"])){
    // User is logged in, redirect to the home page
    header("Location: ../home.php");
    exit;
}

//check if the user submitted the login form
if(isset($_POST["login"])){ 
    //get the username and password from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    //validate the input
    if(empty($username) || empty($password)){
        echo "Please enter both username and password.<br />";
    }else{
        //prepare and execute the sql query to check if the user exists in the database
        $sql = "SELECT * FROM users WHERE username = ?";
        $params = array($username);
        $stmt = sqlsrv_query($conn, $sql, $params);
        if($stmt === false){
            die( print_r( sqlsrv_errors(), true));
        }

        //fetch the result
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        if($row){
            //verify the password
            if(password_verify($password, $row["password"])){
                //set the session variable and redirect to the home page
                $_SESSION["username"] = $username;
                header("Location: ../home.php");
                exit;
            }else{
                echo "Incorrect password.<br />";
            }
        }else{
            echo "User not found.<br />";
        }
    }
}

//check if the user submitted the registration form
if(isset($_POST["register"])){
    //get the username, email and password from the form
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    //validate the input
    if(empty($username) || empty($email) || empty($password)){
        echo "Please enter all the required fields.<br />";
    }else{
        //prepare and execute the sql query to check if the username or email already exists in the database
        $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
        $params = array($username, $email);
        $stmt = sqlsrv_query($conn, $sql, $params);
        if($stmt === false){
            die( print_r( sqlsrv_errors(), true));
        }

        //fetch the result
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        if($row){
            //check which field is already taken
            if($row["username"] == $username){
                echo "Username already taken.<br />";
            }else{
                echo "Email already taken.<br />";
            }
        }else{
            //hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            //prepare and execute the sql query to insert the new user into the database
            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $params = array($username, $email, $hashed_password);
            $stmt = sqlsrv_query($conn, $sql, $params);
            if($stmt === false){
                die( print_r( sqlsrv_errors(), true));
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
<title>Login/Registration Form</title>
</head>
<body>
<h1>Login/Registration Form</h1>
<h2>Login</h2>
<form method="post" action="login.php">
Username: <input type="text" name="username"><br />
Password: <input type="password" name="password"><br />
<input type="submit" name="login" value="Login">
</form>
<h2>Register</h2>
<form method="post" action="login.php">
Username: <input type="text" name="username"><br />
Email: <input type="email" name="email"><br />
Password: <input type="password" name="password"><br />
<input type="submit" name="register" value="Register">
</form>
</body>
</html>
