<?php
require_once('./nav.php');
require_once('./conn.php');

// Check if a driver is logged in (from nav.php)
if (!isset($_SESSION['driver_id'])) {
    // Redirect to login page or handle accordingly
    header("Location: ./?login");
    exit;
}

// Function to update email in driver_info table
function updateEmail($conn, $email, $driver_id)
{
    // Update driver_info table
    $sql = "UPDATE driver_info SET email = ? WHERE DID = ?";
    $params = array($email, $driver_id);
    sqlsrv_query($conn, $sql, $params);

    $sql = "UPDATE driver SET email = ? WHERE DID = ?";
    $params = array($email, $driver_id);
    sqlsrv_query($conn, $sql, $params);
}

// Function to update phone in driver_info table
function updatePhone($conn, $phone, $driver_id)
{
    // Update driver_info table
    $sql = "UPDATE driver_info SET phone = ? WHERE DID = ?";
    $params = array($phone, $driver_id);
    sqlsrv_query($conn, $sql, $params);

    $sql = "UPDATE driver SET phone = ? WHERE DID = ?";
    $params = array($phone, $driver_id);
    sqlsrv_query($conn, $sql, $params);
}

// Function to update password in driver table
function updatePassword($conn, $password, $driver_id)
{
    // Update driver table
    $sql = "UPDATE driver SET password = ? WHERE DID = ?";
    $params = array($password, $driver_id);
    sqlsrv_query($conn, $sql, $params);
}

// Retrieve driver information from the database
$driver_id = $_SESSION['driver_id'];
$driverInfo = array();
$sql = "SELECT * FROM driver_info WHERE DID = ?";
$params = array($driver_id);
$result = sqlsrv_query($conn, $sql, $params);

if ($result && sqlsrv_has_rows($result)) {
    $driverInfo = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

    /*

    // Print data here... //

    */
}

// Check which submit button was clicked and update accordingly
if (isset($_POST['updateEmail'])) {
    $newEmail = $_POST['newEmail'];
    updateEmail($conn, $newEmail, $driver_id);
    $driverInfo['email'] = $newEmail;
}

if (isset($_POST['updatePhone'])) {
    $newPhone = $_POST['newPhone'];
    updatePhone($conn, $newPhone, $driver_id);
    $driverInfo['phone'] = $newPhone;
}

if (isset($_POST['updatePassword'])) {
    $newPassword = $_POST['newPassword'];
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    updatePassword($conn, $hashedPassword, $driver_id);
}

?>

<link rel="stylesheet" href="./style/info.css">

<!-- Print driver info -->
<div class="info">
    <div>
        <span> <?php echo "Name: "; ?></span>
        <p><?php echo $driverInfo['name'] ?></p>
    </div>

    <div>
        <span> <?php echo "DID (Driver ID): "; ?></span>
        <p><?php echo  $driverInfo['DID'] ?></p>
    </div>

    <div>
        <span> <?php echo "Position: "; ?></span>
        <p><?php echo $driverInfo['role'] ?></p>
    </div>

    <div>
        <span> <?php echo "Email: "; ?></span>
        <p> <?php echo $driverInfo['email'] ?></p>
    </div>

    <div>
        <span> <?php echo "phone: "; ?></span>
        <p> <?php echo $driverInfo['phone'] ?></p>
    </div>
</div>

<!-- Update driver info -->
<h1>Update Your Information</h1>
<form method="POST" action="">
    <div class="box">
        <label for="newEmail">New Email:</label>
        <input type="text" name="newEmail" value="<?php echo $driverInfo['email']; ?>">
        <input class="submit" type="submit" name="updateEmail" value="Update Email">
    </div>
    <div class="box">
        <label for="newPhone">New Phone:</label>
        <input type="text" name="newPhone" value="<?php echo $driverInfo['phone']; ?>">
        <input class="submit" type="submit" name="updatePhone" value="Update Phone">
    </div>
    <div class="box">
        <label for="newPassword">New Password:</label>
        <input type="password" name="newPassword" required placeholder="*********">
        <input class="submit" type="submit" name="updatePassword" value="Update Password">
    </div>
</form>

<!-- logout -->
<a class="logout" method="GET" href="?action=logout">Logout <i class="fa-solid fa-right-from-bracket"></i></a>