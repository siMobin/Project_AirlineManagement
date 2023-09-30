<?php

/*
<!-- 
    ////////////////////////////////////////////////////////////////////////////////////////
    // THIS PAGE IS EXCLUSIVELY FOR THE LOGOUT FUNCTIONALITY IN THE ADMIN DESKTOP APP...! //
    // This is applicable when using the 'Alt+L' key or the menu bar to log out...        //
    ////////////////////////////////////////////////////////////////////////////////////////
 -->
*/

logout();
// Logout the admin
function logout()
{
    // Start a session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Unset and destroy the session variables
    unset($_SESSION['admin_name']);
    session_destroy();

    // Redirect to the login page or any other desired page
    header("Location: ./");
    exit;
}
