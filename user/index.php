<?php
require_once './nav.php';
require_once('./conn.php');

// Query to get total airport
$sql = "SELECT COUNT(*) as airport_count FROM locations";
$stmt = sqlsrv_query($conn, $sql);
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $TotalAirport = $row["airport_count"];
}

sqlsrv_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style/home.css">
    <script type="module" crossorigin src="./swiper_slider.js"></script>
    <link rel="modulepreload" href="./swiper_vendor.js" />
    <link rel="stylesheet" href="./style/swiper.css" />
</head>

<body>
    <header>
        <h1>The Airline you know, reimagined for business</h1>
        <p>Your trusted platform for luxury flights all over the globe from the convenience of your own home!</p>
        <a class=".submit" href="./ticket.php">Book Ticket</a>
    </header>

    <!-- Include "Most popular Flights" -->
    <div class="mpf_wrapper">
        <div class="mpf"> <?php include("./mpf.php"); ?></div>
    </div>

    <h1 class="safety_title">Focused on safety, wherever you go!</h1>
    <div class="safety">
        <div>
            <img src="./image/safety.jpg" alt="">
            <h3>Our commitment to your safety</h3>
            <p>With every safety feature and every standard in our Community Guidelines, we're committed to helping to create a safe environment for our users.</p>
        </div>

        <div>
            <img src="./image/safety_2.jpg" alt="">
            <h3>Setting <?php echo $TotalAirport; ?> airports in motion</h3>
            <p>Our services are connect all over the world in various countries which are primarily focused on tourism and luxury experiences. With conacts with nearby luxury hotels and new airports joining our network every year we hope to bring you premium expereiences at an affordable cost.</p>
        </div>
    </div>
    <div class="sliders" style="height: 600px;">
        <?php
        include './slider.php';
        ?>
    </div>
    <?php
    include './footer.html';
    ?>
</body>

</html>