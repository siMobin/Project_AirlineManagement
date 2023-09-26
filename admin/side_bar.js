$(document).ready(function () {
  let isSidebarOpen = true; // Variable to track sidebar state
  let originalSidebarWidth; // Variable to store the original sidebar width
  let originalFooterWidth; // Variable to store the original footer width
  let originalContentMargin; // Variable to store the original content margin
  const magicIcon = $(".logo-hidden"); // Select the magic icon

  // Initially hide the magic icon
  magicIcon.hide();

  // Function to toggle the sidebar and content
  function toggleSidebar() {
    const sidebar = $(".sidebar");
    const footer = $(".footer");
    const content = $("body");

    if (isSidebarOpen) {
      originalSidebarWidth = sidebar.width(); // Store the original sidebar width
      originalFooterWidth = footer.width(); // Store the original footer width
      originalContentMargin = content.css("margin-left"); // Store the original content margin

      sidebar.animate({
        width: "0",
      });

      footer.animate(
        {
          width: "0",
        },
        function () {
          // Animation complete callback
          footer.css("width", "0").hide(); // Set width to 0 and hide the footer
        }
      );

      content.css("margin-left", "0");
    } else {
      sidebar.animate({
        width: 230 + "px",
      }); // Restore original width for sidebar

      footer.show().animate(
        {
          width: originalFooterWidth + "px",
        },
        function () {
          // Animation complete callback
          footer.css("width", ""); // Restore original width for footer
        }
      );

      content.css("margin-left", originalContentMargin); // Restore original margin
    }

    isSidebarOpen = !isSidebarOpen; // Toggle the state

    // Show the magic icon when margin-left is 0, hide it otherwise
    if (content.css("margin-left") === "0px") {
      magicIcon.show();
    } else {
      magicIcon.hide();
    }
  }

  // Toggle the sidebar when the burger icon is clicked
  $("#burger").click(function () {
    toggleSidebar();
  });

  // toggle sub menus
  $(".sub-btn").click(function () {
    $(this).next(".sub-menu").slideToggle();
    $(this).find(".dropdown").toggleClass("rotate");
  });

  // Function to adjust content margin
  function adjustContentMargin() {
    const sidebar = $(".sidebar");
    const content = $("body");

    const sidebarWidth = sidebar.width();
    content.css("margin-left", sidebarWidth + "px");
  }

  // Call the function when the page loads and when it's resized
  window.addEventListener("load", adjustContentMargin);
  window.addEventListener("resize", adjustContentMargin);
});
