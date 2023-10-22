<?php
////////////////// cost configuration ////////////////////
// Read the JSONC configuration file
$configFile = './cost.jsonc';
$jsonContent = file_get_contents($configFile);
if ($jsonContent === false) {
  die("Failed to read JSONC file.");
}
// Remove both single-line and multi-line comments from JSONC
$jsonContent = preg_replace('/\s*(?:(?:\/\/[^\n]*)|(?:\/\*(?:(?!\*\/).)*\*\/))\s*/', '', $jsonContent); // ⚠️multi-line not removed!

// Decode the JSON content
$config = json_decode($jsonContent, true);
if ($config === null) {
  die("Error decoding JSON: " . json_last_error_msg());
}

// cost config //
$discount =  $config['discount'];
$round_trip_discount  = $config['round_trip_discount'];
///////////////////////////////////////////////////////////////

// Image keyword
$imageCategories = ["resort", "hotel", "motel", "city", "Mountain", "lake", "Airport", "hill", "Travel", "Private Jet", "beach", "sea", "sea beach", "visiting spots"];
?>

<link rel="stylesheet" href="./style/discount.css">
<div class="discount">
  <div class="hexagon-gallery">
    <?php
    $usedCategories = []; // Store used categories
    for ($i = 1; $i <= 6; $i++) {
      $randomCategory = getRandomCategory($imageCategories, $usedCategories);
      array_push($usedCategories, $randomCategory); // Add the used category
      $imageURL = "https://source.unsplash.com/900x900/?$randomCategory&category=visitingSpot&orientation=squre";
    ?>

      <div class="hex">
        <img src="<?php echo $imageURL; ?>" alt="<?php echo $i; ?>" loading="lazy">
      </div>
    <?php } ?>

  </div>
  <div class="text">
    <h1>Exclusive Offer <span><?php echo $discount . "%"; ?></span> Discount</h1>
    <h1>Round Trip Offer <span><?php echo $round_trip_discount . "%"; ?></span> Discount</h1>
  </div>
</div>

<!-- ensure that each image is unique -->
<?php
function getRandomCategory($categories, $usedCategories)
{
  $remainingCategories = array_diff($categories, $usedCategories);
  if (empty($remainingCategories)) {
    // If all categories are used, reset the used categories array
    $usedCategories = [];
    $remainingCategories = $categories;
  }
  return $remainingCategories[array_rand($remainingCategories)];
}
?>