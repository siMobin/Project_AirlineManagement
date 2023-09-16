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
  <title>Document</title>
</head>

<body>
  <nav>
    <div class="logo"> <a href="./home?="><i class="fa-solid fa-plane-lock"> private jet</i></a></div>
    <div class="link">
      <a href="#">About</a>
      <a href="#">Contact</a>

      <?php if (isLoggedIn()) : ?>
        <div class="profile">
          <a href="./dashboard.php"><i class="fa-sharp fa-solid fa-user-secret"></i></a>
          <div class="dropdown">
            <a href="./dashboard.php">Dashboard</a>
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
</body>

</html>