<?php require_once('./conn.php'); ?>
<!-- nav.scss line 10 -->
<marquee behavior="scroll" direction="left" scrollamount="5">
    <?php
    $sql = "SELECT [from], [to], date, return_date, trip FROM bookings WHERE date >= CONVERT(date, GETDATE())
    UNION ALL
    SELECT [from], [to], return_date as date, return_date, trip FROM bookings WHERE return_date >= CONVERT(date, GETDATE()) ORDER BY date";
    $stmt = sqlsrv_query($conn, $sql);

    // Ignore this if you have life //
    $sp = "&nbsp;&nbsp;&nbsp;";
    $space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $date = $row['date'];
        if ($date !== null) {
            $formatted_date = $date->format('Y-m-d');
            if ($row['trip'] == 'round-trip' && $row['date'] == $row['return_date']) {
                echo $formatted_date;
                echo "$sp||$sp";
                echo $row['from'];
                echo " ➡ ";
                echo $row['to'];
                echo $space;
            } else {
                echo $formatted_date;
                echo "$sp||$sp";
                echo $row['from'];
                echo "&nbsp;&nbsp; ➡ &nbsp;&nbsp;";
                echo $row['to'];
                echo $space;
            }
        }
    }
    sqlsrv_free_stmt($stmt);
    ?>
</marquee>