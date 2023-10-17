// Define the boundaries for the map
var southWest = L.latLng(-90, -180); // Bottom-left corner of the world
var northEast = L.latLng(90, 180); // Top-right corner of the world
var bounds = L.latLngBounds(southWest, northEast);

// Create the map with a specified minimum zoom level and maximum boundaries
var map = L.map("map", {
  minZoom: 2.5, // Adjust this value to set the desired minimum zoom level
  maxBounds: bounds, // Set the maximum boundaries for the map
}).setView([0, 0], 0);

// Define the custom icon URL
var iconUrl = "./image/plane_icon.webp";
var shadowUrl = "./image/plane_icon_shadow.webp";

// Add markers for each location with the same custom icon and shadow
var markers = [];
locations.forEach(function (location) {
  var markerIcon = L.icon({
    iconUrl: iconUrl,
    shadowUrl: shadowUrl, // Add the path to your modified shadow image
    iconSize: [32, 32], // Customize the icon size if needed
    iconAnchor: [16, 16], // Customize the icon anchor point
    popupAnchor: [0, -16], // Customize the popup anchor point
    shadowSize: [40, 40], // Customize the shadow size
    shadowAnchor: [16, 8], // Customize the shadow anchor point
  });

  // Define the locations as an array of objects with latitude, longitude, and name
  var marker = L.marker([location.lat, location.lng], {
    icon: markerIcon,
  })
    .addTo(map)
    .bindPopup(`<b class="airport_name">Airport:</b> ${location.name || "Unknown"}<br><div class="airport_info">Latitude: ${location.lat}<br>Longitude: ${location.lng}</div>`)
    .on("mouseover", function (e) {
      this.openPopup();
    })
    .on("mouseout", function (e) {
      this.closePopup();
    });
  markers.push(marker);
});

// Create lines connecting all locations in a mesh topology
for (var i = 0; i < locations.length; i++) {
  for (var j = i + 1; j < locations.length; j++) {
    var pathData = [
      [locations[i].lat, locations[i].lng],
      [locations[j].lat, locations[j].lng],
    ];

    var polyline = L.polyline(pathData, {
      color: "blue",
      weight: 0.4,
      dashArray: "1,5",
    }).addTo(map);
  }
}

// Define tile layers for normal view and satellite view
var normalViewLayer = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  attribution: '© <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
  noWrap: true, // Prevent map tiling repeat
});

var satelliteViewLayer = L.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}", {
  attribution: '© <a href="https://www.esri.com/">Esri</a>',
  maxZoom: 18, // You can adjust the max zoom level as needed
});

// Add the normal view layer by default
normalViewLayer.addTo(map);

// Define a control to toggle between normal view and satellite view
L.control.layers({ "Normal View": normalViewLayer, "Satellite View": satelliteViewLayer }).addTo(map);

// Create a button to toggle between views
var toggleButton = L.easyButton("fa-globe", function () {
  // Toggle between normal and satellite views
  if (map.hasLayer(normalViewLayer)) {
    map.removeLayer(normalViewLayer);
    map.addLayer(satelliteViewLayer);
  } else {
    map.removeLayer(satelliteViewLayer);
    map.addLayer(normalViewLayer);
  }
}).addTo(map);

// Fit the map to the bounds of the markers and the lines
var group = new L.featureGroup(markers);
map.fitBounds(group.getBounds());
