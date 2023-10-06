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

<!-- 


This bit of code creates an error when redirecting somewhere using a header function. To fix this issue we used JS which then can be translated to the entirety of the admin site.

-- error:
Warning: Cannot modify header information - headers already sent by (output started at X:\AirManagement\admin\nav_marquee.php:31) in X:\AirManagement\admin\xxx.php on line x


-- fix:
     echo "<script>
            window.location.href = './xxx.php';
            alert('Success!');
            </script>";
    
    

 -->