<?php include './nav.php'; ?>
<?php include './side_bar.php' ?>

<link rel="stylesheet" href="./style/search_user.css">

<form method="post" action="">
    <label for="search_term">Search User: </label>
    <input type="text" id="search_term" name="search_term" required placeholder="UID or Phone">
    <input class="submit" type="submit" value="Search">
</form>

<?php
require './conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search_term = $_POST["search_term"];

    // Modify the SQL query to include information from the users table using a LEFT JOIN
    $sql = "SELECT b.*, u.username FROM bookings AS b
                LEFT JOIN users AS u ON b.email = u.email
                WHERE b.id = ? OR b.email = ? OR b.phone = ? OR u.U_ID = ? order by date desc";

    // Prepare the SQL statement
    $stmt = sqlsrv_prepare($conn, $sql, array(&$search_term, &$search_term, &$search_term, &$search_term));

    if (!$stmt) {
        die("Query preparation failed.");
    }

    // Execute the query
    if (sqlsrv_execute($stmt)) {
        // echo "<h2>Search Results:</h2>";
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Date</th>
                    <th>Return Date</th>
                    <th>Class</th>
                    <th>Passengers</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Trip</th>
                    <th>Cost</th>
                    <th>Confirmation</th>
                    <th>Username</th>
                </tr>";

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['from'] . "</td>";
            echo "<td>" . $row['to'] . "</td>";

            // Check if date and return_date are not null before formatting
            $date = $row['date'] ? $row['date']->format('Y-m-d') : 'N/A';
            $returnDate = $row['return_date'] ? $row['return_date']->format('Y-m-d') : '<span class="oneWay">N/A</span>';

            echo "<td>" . $date . "</td>";
            echo "<td>" . $returnDate . "</td>";
            echo "<td>" . $row['class'] . "</td>";
            echo "<td>" . $row['passengers'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['phone'] . "</td>";
            echo "<td>" . $row['trip'] . "</td>";
            echo "<td>" . $row['cost'] . "</td>";

            // confirmation
            echo "<td class='" . ($row['confirm'] == 1 ? 'confirm' : 'not_confirmed') . "'>";
            echo ($row['confirm'] == 1 ? 'Confirmed' : 'Not Confirmed');
            echo "</td>";

            // username
            echo "<td class='" . (isset($row['username']) ? '' : 'not_found') . "'>";
            echo (isset($row['username']) ? $row['username'] : 'Not Found');
            echo "</td>";

            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Query execution failed.";
    }

    // Clean up resources
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
}
?>