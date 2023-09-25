// portal

function onClick() {
  var x = document.getElementById("sub-links");
  var icon = document.getElementById("i");

  if (x.style.maxHeight) {
    x.style.maxHeight = null;
    // Rotate the icon back to its default position
    icon.style.transform = "rotate(0deg)";
  } else {
    x.style.maxHeight = x.scrollHeight + "px";
    // Flip the icon
    icon.style.transform = "rotate(-180deg)";
  }
}
