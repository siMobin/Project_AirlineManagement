<?php
require './conn.php';

$query = "SELECT destination FROM locations ORDER BY destination";
$result = sqlsrv_query($conn, $query);

if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

$destinations = array();
$uniqueDestinations = array();

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $destination = $row['destination'];

    // Split the destination string based on the "-" character
    $parts = explode("-", $destination);
    $location = trim($parts[0]); // Trim to remove any leading/trailing spaces

    // Check if this location has already been added
    if (!in_array($location, $uniqueDestinations)) {
        $uniqueDestinations[] = $location;
        $destinations[] = $location; // Use $location instead of $destination
    }
}

sqlsrv_close($conn);
?>

<script type="module" crossorigin src="./swiper_slider.js"></script>
<!-- <link rel="modulepreload" href="./swiper_vendor.js" /> -->
<link rel="stylesheet" href="./style/swiper.css" />

<div id="app">
    <!-- Travel slider -->
    <div class="travel-slider">
        <!-- Rotating Planet -->
        <div class="travel-slider-planet">
            <img src="image/earth.svg" />
            <div class="travel-slider-cities">
                <img src="image/usa.svg" />
                <img src="image/england.svg" />
                <img src="image/france.svg" />
                <img src="image/italy.svg" />
                <img src="image/russia.svg" />
                <img src="image/egypt.svg" />
                <img src="image/india.svg" />
                <img src="image/japan.svg" />
            </div>
        </div>
        <!-- Swiper -->
        <div class="swiper">
            <div class="swiper-wrapper">
                <?php
                // Array of image categories
                $imageCategories = ["airport", "visiting place of", "beach of", "business in", "walk on"];

                foreach ($destinations as $destination) {
                    // Select a random image category from the array
                    $randomCategory = $imageCategories[array_rand($imageCategories)];

                    // Use the modified destination name and random category to generate a dynamic image URL.
                    $imageURL = "https://source.unsplash.com/1600x900/?$randomCategory $destination&category=visitingSpot&orientation=landscape";
                    echo "
                        <div class='swiper-slide'>
                        <img src='{$imageURL}' class='travel-slider-bg-image' />
                        <div class='travel-slider-content'>
                            <div class='travel-slider-title'>Travel in {$destination}</div>
                            <div class='travel-slider-subtitle'>with <i class='fa-solid fa-plane-lock travel-slider-subtitle-logo'> private jet</i></div>
                        </div>
                    </div>";
                }
                ?>
            </div>
        </div>
    </div>
</div>