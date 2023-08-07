<?php require_once('./nav.php'); ?>
<?php require_once('./conn.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style/stats.css">
    <script src="./stats.js"></script>
</head>

<body>
    <div class="chart">
        <div class="graph"><?php include './fpm.php'; ?></div>

        <div class="graph"><?php include './ppm.php'; ?></div>
    </div>
</body>

</html>