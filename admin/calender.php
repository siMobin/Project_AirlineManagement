<?php
require('./conn.php');

$highlightedDates = array();

$sql = "SELECT date AS combined_date FROM bookings
        UNION ALL
        SELECT return_date AS combined_date FROM bookings";

$query = sqlsrv_query($conn, $sql);

if ($query === false) {
    die(print_r(sqlsrv_errors(), true));
}

while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
    // Check if the value is not null before formatting
    if ($row['combined_date'] !== null) {
        $combinedDate = $row['combined_date']->format('Y-m-d');
        $highlightedDates[] = $combinedDate;
    }
}
?>

<div id="calendar"></div>

<link rel="stylesheet" href="./style/calender.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.js"></script>

<script>
    // JavaScript code to create and highlight the calendar
    const highlightedDates = <?php echo json_encode($highlightedDates); ?>;
    const calendarDiv = document.getElementById("calendar");

    document.addEventListener('DOMContentLoaded', function() {
        const calendar = new FullCalendar.Calendar(calendarDiv, {
            initialView: 'dayGridMonth',
            eventContent: function(arg) {
                return {
                    ////////////IF NEED/////////////
                    // backgroundColor: 'red',    //
                    // borderColor: 'red',        //
                    // display: 'background'      //
                    ////////////////////////////////
                };
            },
            events: highlightedDates.map(date => ({
                start: date,
            }))
        });

        calendar.render();
    });
</script>