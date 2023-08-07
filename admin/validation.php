<?php require_once('./nav.php'); ?>
<?php require_once('./conn.php'); ?>
<?php
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $sql = "SELECT * FROM bookings WHERE id = ?";
    $params = array($id);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    echo "<table>";
    echo "<tr><th>SID</th><th>From</th><th>To</th><th>Date</th><th>Class</th><th>Passengers</th><th>Email</th><th>Phone</th><th>Trip</th><th>Cost</th><th class='verify_th'>Validity</th><th class='cancel_th'>Cancel Flight</th></tr>";
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $date = $row['date']->format('Y-m-d');

        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['from'] . "</td>";
        echo "<td>" . $row['to'] . "</td>";
        echo "<td>" . $date . "</td>";
        echo "<td>" . $row['class'] . "</td>";
        echo "<td>" . $row['passengers'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['phone'] . "</td>";
        echo "<td>" . $row['trip'] . "</td>";
        echo "<td>" . $row['cost'] . "</td>";
        echo "<td>";

        if ($row['confirm'] != NULL) {
            // done
            echo "The flight has already been confirmed!";
            echo "<form method='post'>
            <input type='hidden' name='id' value='" . $row['id'] . "'>
            
            </form></td>";
        } else if ($date == date('Y-m-d')) {
            // verify
            echo "<form method='post'>
            <input type='hidden' name='id' value='" . $row['id'] . "'>
            <input class='button' type='submit' name='confirm' value='✅'></td> <td>
            <input class='cancel button' type='submit' name='cancel' value='❌'>
            </form></td>";
        } else {
            // cancel
            echo "<form method='post'><input type='hidden' name='id' value='" . $row['id'] . "'><input class='empty' type='submit' name='confirm' value=''></td> <td><input class='cancel button' type='submit' name='cancel' value='❌'></form>";
            echo "</tr>";
        }
    }
}

if (isset($_POST['confirm'])) {
    $id = $_POST['id'];
    $sql = "UPDATE bookings SET confirm = 1 WHERE id = ?";
    $params = array($id);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}

if (isset($_POST['cancel'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM bookings WHERE id = ?";
    $params = array($id);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/validation.css">
</head>

<body>
    <div class="search">
        <form method="post">
            <label for="id">ID:</label>
            <input type="text" id="id" name="id" placeholder="SID">
            <input class="submit" type="submit" name="submit" value="Search">
        </form>
    </div>
</body>

</html>