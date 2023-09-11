// Function to make an AJAX request
function ajaxRequest(url, method, data, callback) {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        callback(xhr.responseText);
      } else {
        console.error("AJAX request failed with status " + xhr.status);
      }
    }
  };
  xhr.open(method, url, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(data);
}

// Function to update the page with location information
function updateLocationInfo(locationData) {
  var locationInfoElement = document.getElementById("locationInfo");
  locationInfoElement.innerHTML = locationData;
}

// Function to get user's location
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, showError);
  } else {
    document.getElementById("locationInfo").innerHTML = "Geolocation is not supported by this browser.";
  }
}

// Function to handle successful geolocation
function showPosition(position) {
  var latitude = position.coords.latitude;
  var longitude = position.coords.longitude;

  // Send the user's location to the PHP script
  ajaxRequest("./info.php", "POST", "latitude=" + latitude + "&longitude=" + longitude, function (response) {
    updateLocationInfo(response);
  });
}

// Function to handle geolocation errors
function showError(error) {
  var locationInfoElement = document.getElementById("locationInfo");
  var errorMessage = "";
  switch (error.code) {
    case error.PERMISSION_DENIED:
      errorMessage = "<div class='warning'>You denied the request for Geolocation!</div>";
      break;
    case error.POSITION_UNAVAILABLE:
      errorMessage = "<div class='warning'>Location information is unavailable!</div>";
      break;
    case error.TIMEOUT:
      errorMessage = "<div class='warning'>The request to get user location timed out!</div>";
      break;
    case error.UNKNOWN_ERROR:
      errorMessage = "<div class='warning'>An unknown error occurred!</div>";
      break;
  }

  // load data from json
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        var locations = JSON.parse(xhr.responseText);
        var maxLocations = 3; // Maximum number of locations to display

        // Generate random indices
        var rand = [];
        while (rand.length < maxLocations && rand.length < locations.length) {
          var randomIndex = Math.floor(Math.random() * locations.length);
          if (rand.indexOf(randomIndex) === -1) {
            rand.push(randomIndex);
          }
        }

        if (rand.length > 0) {
          // errorMessage += "  Here are some random default locations:";
          for (var i = 0; i < rand.length; i++) {
            var index = rand[i];
            errorMessage += "<p class='default_location'><strong>Office: </strong> " + locations[index].street_address + ", ";
            errorMessage += locations[index].city + ", ";
            errorMessage += locations[index].state + " - ";
            errorMessage += locations[index].zip + ", ";
            errorMessage += locations[index].country;
            errorMessage += "<br><strong>Customer Support:</strong> " + locations[index].hotline + "</p>";
          }
        }
        locationInfoElement.innerHTML = errorMessage;
      } else {
        locationInfoElement.innerHTML = errorMessage;
      }
    }
  };
  xhr.open("GET", "default_location.json", true);
  xhr.send();
}

// Trigger location retrieval when the page loads
window.addEventListener("load", getLocation);
