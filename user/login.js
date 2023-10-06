/*

// JS for dragging the form //

*/

var form = document.getElementById("form");
var isDragging = false;
var offsetX, offsetY;
var initialX, initialY;
var formWidth, formHeight;

// Function to start dragging
function startDragging(event) {
  if (event.target.tagName.toLowerCase() !== "input") {
    isDragging = true;

    if (event.type === "touchstart") {
      var touch = event.touches[0];
      var rect = form.getBoundingClientRect();
      initialX = touch.clientX - rect.left;
      initialY = touch.clientY - rect.top;
    } else {
      var rect = form.getBoundingClientRect();
      initialX = event.clientX - rect.left;
      initialY = event.clientY - rect.top;
    }

    var rect = form.getBoundingClientRect();
    formWidth = rect.width;
    formHeight = rect.height;

    event.preventDefault();

    // Set cursor style
    form.style.cursor = "grabbing";

    // Prevent text selection during dragging
    document.body.style.userSelect = "none";
  }
}

// Event listener to start dragging when the form is clicked
form.addEventListener("mousedown", startDragging);
form.addEventListener("touchstart", startDragging);

// Function to move dragging
function moveDragging(event) {
  if (isDragging) {
    if (event.type === "touchmove") {
      var touch = event.touches[0];
      var x = touch.clientX - initialX;
      var y = touch.clientY - initialY;
    } else {
      var x = event.clientX - initialX;
      var y = event.clientY - initialY;
    }

    var maxX = window.innerWidth - formWidth;
    var maxY = window.innerHeight - formHeight;

    // Ensure the form stays within the screen boundaries
    x = Math.min(maxX, Math.max(0, x));
    y = Math.min(maxY, Math.max(0, y));

    form.style.left = x + "px";
    form.style.top = y + "px";

    // Adjust the right and bottom properties to maintain corner movement
    form.style.right = "auto";
    form.style.bottom = "auto";

    event.preventDefault();
  }
}

// set the new position of the form
document.addEventListener("mousemove", moveDragging);
document.addEventListener("touchmove", moveDragging);

// Function to stop dragging
function stopDragging() {
  if (isDragging) {
    isDragging = false;

    // Reset cursor style
    // It's a backup style
    form.style.cursor = "grab";
  }
}

// Event listener to stop dragging
document.addEventListener("mouseup", stopDragging);
document.addEventListener("touchend", stopDragging);
