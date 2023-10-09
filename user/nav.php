<?php
session_start();
// Check if the user is already logged in
function isLoggedIn()
{
  return isset($_SESSION["username"]);
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
  logout();
}

// Logout the user
function logout()
{
  // session_destroy();
  unset($_SESSION['username']);
  header("Location: ./logout=!?");
  exit;
}

$username = $_SESSION["username"] ?? "UserNotFound";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="./icon.ico">
  <title>Privet Jet</title>
</head>

<body>
  <nav>
    <div class="logo"> <?php echo "<a href='./=$username'><i class='fa-solid fa-plane-lock'><span> </span></i></a>"; ?></div><!-- dynamically hide large logo when in mobile device -->
    <div class="link">
      <a href="#" class="pop_location">Available Airport</a>
      <a href="#">About</a>
      <a href="#">Contact</a>

      <?php if (isLoggedIn()) : ?>
        <div class="profile">
          <?php echo "<a href='./dashboard.php?=$username'><i class='fa-sharp fa-solid fa-user-secret'></i></a>"; ?>
          <div class="dropdown">
            <?php echo "<a href='./dashboard.php?=$username'>Dashboard</a>"; ?>
            <a method="GET" href="?action=logout">Logout</a>
          </div>
        </div>
      <?php else : ?>
        <div>
          <a class="login" href="./login.php">Login</a>
        </div>
      <?php endif; ?>
    </div>
  </nav>

  <div class="cover">
    <!-- <i class="fa-solid fa-xmark close"></i> -->
    <div class="contents">
      <!-- close button //* move anywhere-->
      <i class="fa-solid fa-xmark close"></i>

      <h1>Available Airport</h1>
      <?php
      require("./conn.php");
      $sql = "SELECT destination FROM locations order by destination";
      $result = sqlsrv_query($conn, $sql);

      $locations = array();
      while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        $locations = $row['destination'];
        echo "<li>" . $locations . "</li>" . "<br>";
      }
      ?>

    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="./pop_location.js">
  </script>
</body>

</html>