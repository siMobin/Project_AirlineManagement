<div>
    <canvas id="passengerChart"></canvas>
</div>

<?php
require './conn.php';

$classColumns = array();

// Check if the connection was successful
if ($conn) {
    // Query distinct class values
    $getClassValuesQuery = "SELECT DISTINCT [class] FROM bookings"; // Use [class]
    $classResult = sqlsrv_query($conn, $getClassValuesQuery);

    if ($classResult === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    while ($classRow = sqlsrv_fetch_array($classResult, SQLSRV_FETCH_ASSOC)) {
        $classColumns[] = $classRow['class'];
    }

    // Create a dynamic SQL query to sum passengers for each class
    $query = "SELECT * FROM (
            SELECT 
                RIGHT('00' + CAST(DATEPART(MONTH, date) AS VARCHAR(2)), 2) + '-' + CAST(YEAR(date) AS VARCHAR(4)) AS MonthYear";

    foreach ($classColumns as $class) {
        $query .= ", SUM(CASE WHEN [class] = '$class' THEN passengers ELSE 0 END) AS [$class]";
    }

    $query .= " FROM bookings
                    WHERE date >= DATEADD(MONTH, -11, GETDATE()) -- Last 12 months
                    GROUP BY RIGHT('00' + CAST(DATEPART(MONTH, date) AS VARCHAR(2)), 2) + '-' + CAST(YEAR(date) AS VARCHAR(4))
        ) AS Subquery
        ORDER BY CAST(SUBSTRING(MonthYear, 4, 4) AS INT), CAST(SUBSTRING(MonthYear, 1, 2) AS INT);
        ";


    $result = sqlsrv_query($conn, $query);

    if ($result === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $data = array();
    $labels = array();

    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        $labels[] = $row['MonthYear'];
        foreach ($classColumns as $class) {
            $classData[$class][] = $row[$class];
        }
    }

    sqlsrv_free_stmt($result);

    $datasets = array();

    foreach ($classColumns as $class) {
        $dataset = array(
            "label" => $class,
            "data" => $classData[$class],
            "backgroundColor" => "rgba(75, 192, 192, 0.2)",
            "borderColor" => "rgba(75, 192, 192, 1)",
            "borderWidth" => 1,
            "fill" => false
        );

        $datasets[] = $dataset;
    }

    $dataForChart = array(
        "labels" => $labels,
        "datasets" => $datasets
    );

    $jsonData = json_encode($dataForChart);
}

?>

<script>
    var chartData = <?php echo $jsonData; ?>;
</script>

<script src="./ppc.js"></script>