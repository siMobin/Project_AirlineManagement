<?php
session_start();
// Check if the user is already logged in
function isLoggedIn() {
    return isset($_SESSION["username"]);
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logout();
}

// Logout the user
function logout() {
    session_destroy();
    header("Location: ../login/login.php");
    exit;
}
?>

<nav>
    <div class="logo"> <a href="../home.php"><i class="fa-solid fa-plane-lock"> private jet</i></a></div>
    <div class="link">
<a href="#">About</a>
<a href="#">Contact</a>
  
  <?php if (isLoggedIn()): ?>
    <div class="profile">
      <!-- <a href="#" class="profile-icon">Profile</a> -->
      <a href="#" ><img class="profile-icon" src="../image/ticket_bg.jpg" alt=""></a>
      <div class="dropdown">
        <a href="#">Dashboard</a>
        <a method="GET" href="?action=logout">Logout</a>
      </div>
    </div>
  <?php else: ?>
    <div class="login">
      <a href="../login/login.php">Login</a>
    </div>
  <?php endif; ?>
</div>
</nav>


