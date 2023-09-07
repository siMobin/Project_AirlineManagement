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
</head>

<body>
    <header>
        <h1>The Airline you know, reimagined for business...</h1>
        <p>A platform for managing Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio, minima!</p>
        <a class=".submit" href="./ticket.php">Book Ticket</a>
    </header>
    <h1 class="safety_title">Focused on safety, wherever you go!</h1>
    <div class="safety">
        <div>
            <img src="./image/safety.jpg" alt="">
            <h3>Our commitment to your safety</h3>
            <p>With every safety feature and every standard in our Community Guidelines, we're committed to helping to create a safe environment for our users.</p>
        </div>

        <div>
            <img src="./image/safety_2.jpg" alt="">
            <h3>Setting <?php echo $TotalAirport; ?> airport in motion</h3>
            <p>With Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sed, odit? Velit sed cumque odit dolorum, quibusdam placeat debitis sint assumenda voluptas eos perferendis quos deleniti?</p>
        </div>
    </div>
    <?php
    include './footer.html';
    ?>
</body>

</html>