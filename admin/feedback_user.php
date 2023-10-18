<?php require_once('./nav.php'); ?>
<?php include './side_bar.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/feedback_user.css">
</head>

<body>
    <h1>Feedback Details</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Category</th>
            <th>Subject</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Country</th>
            <th>Message</th>
            <th>Ticket File</th>
            <th>FID</th>
            <th>Journey Date</th>
            <th>Submission Time</th>
        </tr>

        <?php
        // database connection
        require("./conn.php");

        // Retrieve feedback details from the database
        $sql = "SELECT * FROM feedback ORDER BY submission_time DESC";
        $stmt = sqlsrv_query($conn, $sql);

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            echo "<tr>";

            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['category'] . "</td>";
            echo "<td>" . $row['subject'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['phone'] . "</td>";

            // print location info under 16 character
            $country = $row['country'];
            $countryTextSize = 16;
            $limitedCountry = strlen($country) > $countryTextSize ? substr($country, 0, $countryTextSize) . "..." : $country;
            echo "<td>" . $limitedCountry . "</td>";

            // message body under 32 character
            echo "<td>";
            // make message smaller in the cell
            $message = $row['message'];
            $messageSize = 32;
            $limitedMessage = strlen($message) > $messageSize ? substr($message, 0, $messageSize) . "..." : $message;
            $messageDownloadLink = strlen($message) > $messageSize ? true : false;
            if ($messageDownloadLink) {
                echo '<a href="download_feed.php?message=' . urlencode($message) . '" download>' . htmlspecialchars($limitedMessage) . '</a>';
            } else {
                echo htmlspecialchars($limitedMessage);
            }
            echo "</td>";

            // for attachment
            echo "<td>";
            // Determine if the file is an image or PDF
            if (!is_null($row['ticket_file'])) {
                $fileType = finfo_buffer(finfo_open(), $row['ticket_file'], FILEINFO_MIME_TYPE);

                if (strpos($fileType, 'image') !== false) {
                    echo "<img src='data:$fileType;base64," . base64_encode($row['ticket_file']) . "' alt='Image'>";
                } elseif ($fileType == 'application/pdf') {
                    echo "<a href='download_feed.php?id=" . $row['id'] . "'>Download PDF</a>";
                } else {
                    echo "<p class='not-found'>Unknown file format</p>";
                }
            } else {
                echo "<p class='not-found'>No file uploaded</p>";
            }
            echo "</td>";

            echo "<td>" . (!is_null($row['ticket_number']) ? $row['ticket_number'] : "<p class='not-found'>N/A</p>") . "</td>";
            echo "<td>" . (!is_null($row['journey_date']) ? $row['journey_date']->format('Y-m-d') : "<p class='not-found'>N/A</p>") . "</td>";
            echo "<td>" . (!is_null($row['submission_time']) ? $row['submission_time']->format('Y-m-d H:i:s') : "N/A") . "</td>";

            echo "</tr>";
        }
        ?>
    </table>
</body>

</html>