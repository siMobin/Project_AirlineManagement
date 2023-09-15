<?php
function isMobileDevice()
{
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $mobileKeywords = array('Android', 'iPhone', 'iPad', 'Windows Phone', 'Mobile');

    foreach ($mobileKeywords as $keyword) {
        if (stripos($userAgent, $keyword) !== false) {
            return true; // It's a mobile device
        }
    }

    return false; // It's not a mobile device (likely a desktop)
}

if (isMobileDevice()) {
    // Redirect non-desktop users to another page or display a message
    header('Location: mobile.html');
    exit;
}
?>

<script>
    if ('ontouchstart' in window || window.innerWidth <= 1280) {
        // Redirect or show a message for mobile users
        window.location.href = './mobile.html'; // Replace with your desired URL
    }
</script>