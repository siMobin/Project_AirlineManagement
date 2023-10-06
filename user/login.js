/*

// JS for dragging the form //

*/

var form = document.getElementById("form");
var isDragging = false;
var offsetX, offsetY; // page position

// touch event
function getPointerPosition(event) {
  if (event.type.startsWith("touch")) {
    var touch = event.touches[0];
    return { x: touch.clientX, y: touch.clientY };
  } else {
    return { x: event.clientX, y: event.clientY };
  }
}

form.addEventListener("mousedown", startDragging); // for desktop
form.addEventListener("touchstart", startDragging); // for touch device

function startDragging(event) {
  isDragging = true;

  // Get the initial pointer position
  var pointerPosition = getPointerPosition(event);
  offsetX = pointerPosition.x - form.getBoundingClientRect().left;
  offsetY = pointerPosition.y - form.getBoundingClientRect().top;

  // Set cursor style
  form.style.cursor = "grabbing";

  // Prevent default behavior to avoid touch gestures interfering
  event.preventDefault();
}

document.addEventListener("mousemove", moveDragging); // for desktop
document.addEventListener("touchmove", moveDragging); // for touch device

function moveDragging(event) {
  if (isDragging) {
    // Get the current pointer position
    var pointerPosition = getPointerPosition(event);

    // Calculate the new position of the form
    var newX = pointerPosition.x - offsetX;
    var newY = pointerPosition.y - offsetY;

    // Calculate the boundaries
    var maxX = window.innerWidth - form.clientWidth;
    var maxY = window.innerHeight - form.clientHeight;

    // Ensure the form stays within the viewport
    newX = Math.min(maxX, Math.max(0, newX));
    newY = Math.min(maxY, Math.max(0, newY));

    // Set the new position of the form
    form.style.right = maxX - newX + "px";
    form.style.bottom = maxY - newY + "px";
  }
}

document.addEventListener("mouseup", stopDragging);
document.addEventListener("touchend", stopDragging);

function stopDragging() {
  if (isDragging) {
    isDragging = false;

    // Reset cursor style
    // It's a backup style
    form.style.cursor = "grab";
  }
}
