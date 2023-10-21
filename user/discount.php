<link rel="stylesheet" href="./style/discount.css">

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

$imageCategories = ["Airport Terminal", "Tourist Attractions", "Famous Places", "Travel Destinations", "Scenic Views", "Airport Aerial View", "Airport Building", "beach", "sea", "sea beach"];
?>
<div class="discount">
  <div class="hexagon-gallery">
    <?php for ($i = 1; $i <= 6; $i++) {
      $randomCategory = $imageCategories[array_rand($imageCategories)];
      $imageURL = "https://source.unsplash.com/600x300/?$randomCategory&category=visitingSpot&orientation=landscape";
    ?>
      <div class="hex">
        <img src="<?php echo $imageURL ?>" alt="Hexagon Image <?php echo $i; ?>">
      </div>
    <?php } ?>
  </div>
  <div class="text">
    <h1>Exclusive Offer <span><?php echo $discount . "%"; ?></span> Discount</h1>
    <h1>Round Trip Offer <span><?php echo $round_trip_discount . "%"; ?></span> Discount</h1>
  </div>
</div>