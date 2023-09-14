$(document).ready(function () {
  //jquery for toggle sub menus
  $(".sub-btn").click(function () {
    $(this).next(".sub-menu").slideToggle();
    $(this).find(".dropdown").toggleClass("rotate");
  });
});

function adjustContentMargin() {
  const sidebar = document.querySelector(".sidebar");
  const content = document.querySelector("body");

  if (sidebar && content) {
    const sidebarWidth = sidebar.offsetWidth;
    content.style.marginLeft = sidebarWidth + "px";
  }
}

// Call the function when the page loads and when it's resized
window.addEventListener("load", adjustContentMargin);
window.addEventListener("resize", adjustContentMargin);
