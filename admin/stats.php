<?php require_once('./nav.php'); ?>
<?php include './side_bar.php' ?>
<?php require('./conn.php'); ?>
<?php
// Query to get total number of bookings
$sql = "SELECT COUNT(*) as total_bookings FROM bookings";
$stmt = sqlsrv_query($conn, $sql);
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $TotalBookings = $row["total_bookings"];
}

// Function to format cost with suffix
function format_cost($cost)
{
    if ($cost >= 1000000000) {
        return "$" . round($cost / 1000000000, 2) . " B";
    } elseif ($cost >= 1000000) {
        return "$" . round($cost / 1000000, 2) . " M";
    } elseif ($cost >= 1000) {
        return "$" . round($cost / 1000, 2) . " K";
    } else {
        return "$" . round($cost, 2);
    }
}

// Query to get total cost of bookings
$sql = "SELECT SUM(cost) as revenue FROM bookings";
$stmt = sqlsrv_query($conn, $sql);
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $TotalRevenue = format_cost($row["revenue"]);
}

// Query to get average cost per booking
$sql = "SELECT AVG(cost) as avg_cost FROM bookings";
$stmt = sqlsrv_query($conn, $sql);
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $AverageCostperBooking = format_cost($row["avg_cost"]);
}

// Query to get total number of confirmed bookings
$sql = "SELECT COUNT(*) as total_confirmed FROM bookings WHERE confirm = 1";
$stmt = sqlsrv_query($conn, $sql);
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $TotalConfirmedBookings = $row["total_confirmed"];
}

// Query to get total number of passengers
$sql = "SELECT SUM(passengers) as total_passengers FROM bookings";
$stmt = sqlsrv_query($conn, $sql);
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $TotalPassengers = $row["total_passengers"];
}

// Query to get average number of passengers per booking
$sql = "SELECT AVG(passengers) as avg_passengers FROM bookings";
$stmt = sqlsrv_query($conn, $sql);
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $avgPassengers = round($row["avg_passengers"]);
}

// Query to get average flights per month
$sql = "SELECT AVG(count) as avg_flights FROM (SELECT COUNT(*) as count FROM bookings GROUP BY FORMAT(date, 'MM-yyyy')) as subquery";
$stmt = sqlsrv_query($conn, $sql);
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $AverageFlightsperMonth = round($row["avg_flights"]);
}

// Query to get top flight month
$sql = "SELECT TOP 1 FORMAT(date, 'MM-yyyy') as month_year, COUNT(*) as count FROM bookings GROUP BY FORMAT(date, 'MM-yyyy') ORDER BY count DESC";
$stmt = sqlsrv_query($conn, $sql);
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $TopFlightMonth = $row["month_year"];
}

// Query to get most popular class
$sql = "SELECT TOP 1 class, COUNT(*) as count FROM bookings GROUP BY class ORDER BY count DESC";
$stmt = sqlsrv_query($conn, $sql);
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $MostPopularClass = $row["class"];
}

// Query to get most popular airport
$sql = "SELECT TOP 1 [from], COUNT(*) as count FROM bookings GROUP BY [from] ORDER BY count DESC";
$stmt = sqlsrv_query($conn, $sql);
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $MostPopularAirport = $row["from"];
}

sqlsrv_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style/stats.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="./stats.js"></script>
</head>

<body>

    <div class="blocks_wrapper">
        <div class="blocks">
            <h2>Busy Airport</h2>
            <i class="fa-solid fa-plane-departure"></i>
            <p><?php echo $MostPopularAirport; ?></p>
        </div>

        <div class="blocks">
            <h2>Total Bookings</h2>
            <i class="fa-solid fa-ticket-simple"></i>
            <p><?php echo $TotalBookings; ?></p>
        </div>

        <div class="blocks">
            <h2>Total Revenue</h2>
            <i class="fa-solid fa-coins"></i>
            <p><?php echo $TotalRevenue; ?></p>
        </div>

        <div class="blocks">
            <h2>Average Revenue per Booking</h2>
            <i class="fa-sharp fa-solid fa-filter-circle-dollar"></i>
            <p><?php echo $AverageCostperBooking; ?></p>
        </div>

        <div class="blocks">
            <h2>Total Confirmed Bookings</h2>
            <i class="fa-solid fa-plane-circle-check"></i>
            <p><?php echo $TotalConfirmedBookings; ?></p>
        </div>

        <div class="blocks">
            <h2>Total Passengers carrying</h2>
            <i class="fa-sharp fa-solid fa-person-walking-luggage"></i>
            <p><?php echo $TotalPassengers; ?></p>
        </div>

        <div class="blocks">
            <h2>Average Passengers Per Booking</h2>
            <i class="fa-sharp fa-solid fa-gauge"></i>
            <p><?php echo $avgPassengers; ?></p>
        </div>

        <div class="blocks">
            <h2>Average Flights per Month</h2>
            <i class="fa-solid fa-plane-circle-exclamation"></i>
            <p><?php echo $AverageFlightsperMonth; ?></p>
        </div>

        <div class="blocks">
            <h2>Top Flight Month</h2>
            <!-- <i class="fa-solid fa-plane-arrival"></i> -->
            <i class="fa-sharp fa-solid fa-calendar-days"></i>
            <p><?php echo $TopFlightMonth; ?></p>
        </div>

        <div class="blocks">
            <h2>Most Popular Class</h2>
            <i class="fa-solid fa-champagne-glasses"></i>
            <p><?php echo $MostPopularClass; ?></p>
        </div>
    </div>

    <div class="chart">
        <div class="graph"><?php include './fpm.php'; ?></div>

        <div class="graph"><?php include './ppm.php'; ?></div>

        <div class="graph"><?php include './cpm.php'; ?></div>

        <div class="graph"><?php include './ppc.php'; ?></div>

        <div class="graph fba"><?php include './fba.php'; ?></div>
    </div>
</body>

</html>