<?php
include './nav.php';

// for better performance Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ./login.php?=");
    exit;
}
?>

<link rel="stylesheet" href="./style/dashboard.css">

<div class="radio-tabs">
    <input class="state" type="radio" title="Input1" name="input-state" id="radio1" checked />
    <input class="state" type="radio" title="Input2" name="input-state" id="radio2" />

    <div class="tabs">
        <label for="radio1" id="first-tab" class="tab">
            <div class="tab-label">Bookings</div>
        </label>

        <label for="radio2" id="second-tab" class="tab">
            <div class="tab-label">Profile</div>
        </label>
    </div>

    <!-- content! -->
    <div class="panels">
        <div id="first-panel" class="panel active animated slideInRight">
            <?php include './bookings.php'; ?>
        </div>

        <div id="second-panel" class="panel animated slideInRight">
            <?php require './conn.php'; ?>
            <?php include './profile.php'; ?>
        </div>
    </div>
</div>

<?php include './footer.html'; ?>