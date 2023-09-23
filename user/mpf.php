<?php require('./conn.php'); ?>

<?php
// Read the JSON file and parse it
$jsonFile = 'classes.json';
$jsonData = file_get_contents($jsonFile);
$classesData = json_decode($jsonData, true);

// Check if the JSON file was successfully loaded
if ($classesData === null) {
    die('Error loading JSON file.');
}

// Set a default class
$defaultClass = reset($classesData['classes']);

// Check if a class was selected and store it in a variable
$selectedClass = isset($_POST['selected_class']) ? $_POST['selected_class'] : $defaultClass;
?>

<link rel="stylesheet" href="./style/mpf.css">

<form method="post">
    <label class="" for="class_select">Most Popular Flights</label>
    <select name="selected_class" class="submit" id="class_select" onchange="this.form.submit()">
        <?php
        foreach ($classesData['classes'] as $class) {
            $selected = ($class === $selectedClass) ? 'selected' : '';
            echo '<option value="' . $class . '" ' . $selected . '>' . $class . '</option>';
        }
        ?>
    </select>
</form>

<?php

//////////////////////////check////////////////////////////////
/////// Handle form submission ////                          //
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {              //
//     echo 'Selected Class is ' . $selectedClass;           //
// } else {                                                  //
//     echo 'Default Class is ' . $defaultClass;             //
// }                                                         //
// echo "<h2>Class: " . $selectedClass . "</h2>";            //
///////////////////////////////////////////////////////////////

// Query to get most popular flight for each class
$sql = "SELECT TOP 5 [from],[to], COUNT(*) as count, AVG(cost/passengers) as average_cost FROM bookings WHERE class = ? GROUP BY [from],[to] ORDER BY count DESC";
$params = array($selectedClass);
$stmt = sqlsrv_query($conn, $sql, $params);

echo "<table>";
echo "<tr>
<th>From</th>
<th>To</th>
<th>Average Cost</th>
</tr>";

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    echo "<tr style='border-bottom: 1px solid rgba(35, 180, 255, 0.3);'>"; // it sucks
    echo "<td>" . $row['from'] . "</td>";
    echo "<td>" . $row['to'] . "</td>";
    echo "<td>" . number_format($row['average_cost'], 2) . "</td>";
    echo "</tr>";
}
echo "</table>";

sqlsrv_close($conn);
?>