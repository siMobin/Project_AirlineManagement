document.addEventListener("DOMContentLoaded", function () {
  let isSidebarOpen = true; // Variable to track sidebar state
  let originalFooterWidth; // Variable to store the original footer width
  let originalContentMargin; // Variable to store the original content margin
  const magicIcon = document.querySelector(".logo-hidden"); // Select the magic icon

  // Initially hide the magic icon
  magicIcon.style.display = "none";

  // Function to toggle the sidebar and content with animation
  function toggleSidebar() {
    const sidebar = document.querySelector(".sidebar");
    const footer = document.querySelector(".footer");
    const content = document.body;

    if (isSidebarOpen) {
      originalSidebarWidth = getComputedStyle(sidebar).width; // Store the original sidebar width
      originalFooterWidth = getComputedStyle(footer).width; // Store the original footer width
      originalContentMargin = getComputedStyle(content).marginLeft; // Store the original content margin

      // Add transitions
      sidebar.style.transition = "width 0.3s";
      footer.style.transition = "width 0.2s";
      content.style.transition = "margin-left 0.3s";

      sidebar.style.width = "0";
      footer.style.width = "0";
      content.style.marginLeft = "0";

      // Animation complete callback
      setTimeout(function () {
        footer.style.display = "none";
        sidebar.style.transition = "";
        footer.style.transition = "";
        content.style.transition = "";
      }, 300); // Set the timeout to match the transition duration
    } else {
      // Add transitions
      sidebar.style.transition = "width 0.3s";
      footer.style.transition = "width 0.2s";
      content.style.transition = "margin-left 0.3s";

      sidebar.style.width = "230px"; // Restore original width for sidebar
      footer.style.display = "flex"; // flex from css
      footer.style.width = originalFooterWidth;
      content.style.marginLeft = originalContentMargin;

      // Animation complete callback
      setTimeout(function () {
        sidebar.style.transition = "";
        footer.style.transition = "";
        content.style.transition = "";
      }, 300); // Set the timeout to match the transition duration
    }

    isSidebarOpen = !isSidebarOpen; // Toggle the state

    // Show the magic icon when margin-left is 0, hide it otherwise
    if (getComputedStyle(content).marginLeft === "0px") {
      magicIcon.style.display = "none";
    } else {
      magicIcon.style.display = "block";
    }
  }

  // Toggle the sidebar when the burger icon is clicked
  document.getElementById("burger").addEventListener("click", function () {
    toggleSidebar();
  });

  // toggle sub menus
  const subBtns = document.querySelectorAll(".sub-btn");
  subBtns.forEach(function (subBtn) {
    subBtn.addEventListener("click", function () {
      const subMenu = this.nextElementSibling;
      const dropdownIcon = this.querySelector(".dropdown");

      if (subMenu.style.maxHeight) {
        subMenu.style.maxHeight = null;
        dropdownIcon.classList.remove("rotate");
      } else {
        subMenu.style.maxHeight = subMenu.scrollHeight + "px";
        dropdownIcon.classList.add("rotate");
      }
    });
  });

  // Function to adjust content margin
  function adjustContentMargin() {
    const sidebar = document.querySelector(".sidebar");
    const content = document.body;

    const sidebarWidth = getComputedStyle(sidebar).width;
    content.style.marginLeft = sidebarWidth;
  }

  // Call the function when the page loads and when it's resized
  window.addEventListener("load", adjustContentMargin);
  window.addEventListener("resize", adjustContentMargin);
});
