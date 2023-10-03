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
    <select name="selected_class" class="submit" id="class_select">
        <?php
        foreach ($classesData['classes'] as $class) {
            $selected = ($class === $selectedClass) ? 'selected' : '';
            echo '<option value="' . $class . '" ' . $selected . '>' . $class . '</option>';
        }
        ?>
    </select>
</form>

<div id="table-container">
    <!-- Table data will be inserted here -->
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="./mpf.js"></script>