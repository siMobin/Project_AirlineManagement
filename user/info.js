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
  switch (error.code) {
    case error.PERMISSION_DENIED:
      document.getElementById("locationInfo").innerHTML = "User denied the request for Geolocation.";
      break;
    case error.POSITION_UNAVAILABLE:
      document.getElementById("locationInfo").innerHTML = "Location information is unavailable.";
      break;
    case error.TIMEOUT:
      document.getElementById("locationInfo").innerHTML = "The request to get user location timed out.";
      break;
    case error.UNKNOWN_ERROR:
      document.getElementById("locationInfo").innerHTML = "An unknown error occurred.";
      break;
  }
}

// Trigger location retrieval when the page loads
window.addEventListener("load", getLocation);
