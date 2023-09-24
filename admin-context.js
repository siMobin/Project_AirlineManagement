////////////////////////////////////////////////
//       Specially made for js injection     //
//       Nativefire Injection               //
//       Context Menu                      //
//       Only for Admin site              //
///////////////////////////////////////////

///////////  Hide the sidebar elements for application  //////////
// const sidebar = document.querySelector(".sidebar");          //
/////////// make the width & opacity of the sidebar to 0 /////////
// sidebar.style.width = "0";                                   //
// sidebar.style.opacity = "0";                                 //
////////////////////////// wait //////////////////////////////////

// Function to create and show the context menu
function showContextMenu(event) {
  event.preventDefault();

  // Check if a context menu is already displayed then remove it
  hideContextMenu();

  // Create the context menu element
  const contextMenu = document.createElement("div");
  contextMenu.className = "context-menu";
  contextMenu.style.position = "absolute"; // click position
  contextMenu.style.boxShadow = "0px 0px 10px rgba(0,0,0,0.2)";
  contextMenu.style.backgroundColor = "#e8f4fa";
  contextMenu.style.border = "1px solid rgba(29, 146, 204,0.3)";
  contextMenu.style.borderRadius = "5px";
  contextMenu.style.left = `${event.pageX}px`; // mouse position of pageX
  contextMenu.style.top = `${event.pageY}px`; // mouse position of pageY
  contextMenu.style.zIndex = "100000";
  contextMenu.style.minWidth = "260px";
  contextMenu.style.fontSize = "14px";
  contextMenu.style.fontWeight = "400";
  contextMenu.style.padding = "0.5em 0";

  // Define the menu items & link
  const menuItems = [
    // Add reload, cut, copy, paste, and select all functionality
    { text: "🔄 Reload", shortcut: "Ctrl+R", action: () => reloadPage() },
    { gap: "" },
    { text: "✂️ Cut", shortcut: "Ctrl+X", action: () => cutText() },
    { gap: "" },
    { text: "📋 Copy", shortcut: "Ctrl+C", action: () => copyText() },
    { gap: "" },
    { text: "📄 Paste", shortcut: "Ctrl+V", action: () => pasteText() },
    { gap: "" },
    { text: "📑 Select All", shortcut: "Ctrl+A", action: () => selectAllText() },
    { line: "" },
    { gap: "" },
    // link list with keyboard shortcuts
    { text: "Validation", link: "http://localhost/admin/validation.php", shortcut: "Alt+Shift+V" },
    { gap: "" },
    { text: "Hotel Assign", link: "http://localhost/admin/hotel_assign.php", shortcut: "Alt+Shift+H" },
    { gap: "" },
    { text: "Flight Assign", link: "http://localhost/admin/flight_assign.php", shortcut: "Alt+Shift+F" },
    { gap: "" },
    { text: "Locations", link: "http://localhost/admin/locations.php", shortcut: "Alt+Shift+A" },
    { gap: "" },
    { text: "Drivers", link: "http://localhost/admin/drivers.php", shortcut: "Alt+Shift+D" },
    { gap: "" },
    { text: "Schedule", link: "http://localhost/admin/schedule.php", shortcut: "Alt+Shift+S" },
    { gap: "" },
    { text: "Stats", link: "http://localhost/admin/stats.php", shortcut: "Alt+Shift+R" },

    // extra link
    { line: "" }, // Add a line separator
    { gap: "" },
    { text: "Visit user site", link: "http://localhost/user/", shortcut: "Alt+U" },
    { gap: "" },
    { line: "" }, // Add a line separator

    // about
    { text: "About", link: "http://localhost/user/about.html", shortcut: " " },
    { gap: "" },
    { text: "Help", link: "https://github.com/nativefier/nativefier", shortcut: " ", target: "_blank" },
  ];

  ////////////////////// ctrl functions//////////////////
  //   reload || Cut || Copy || Past || Select All   ///
  /////////////////////////////////////////////////////

  // Function to reload the current page
  function reloadPage() {
    location.reload();
  }

  // Function to cut selected text to the clipboard
  function cutText() {
    copyText(); // Copy the selected text
    const selection = window.getSelection();
    if (selection.rangeCount > 0) {
      const range = selection.getRangeAt(0);
      range.deleteContents();
    }
  }

  // Function to copy selected text to the clipboard
  function copyText() {
    const selectedText = window.getSelection().toString();
    if (selectedText) {
      navigator.clipboard.writeText(selectedText);
    }
  }

  // Function to paste text from the clipboard
  function pasteText() {
    navigator.clipboard.readText().then(text => {
      const selection = window.getSelection();
      if (selection.rangeCount > 0) {
        const range = selection.getRangeAt(0);
        range.deleteContents();
        range.insertNode(document.createTextNode(text));
      }
    });
  }

  // Function to select all text on the page
  function selectAllText() {
    const selection = window.getSelection();
    const range = document.createRange();
    range.selectNodeContents(document.body);
    selection.removeAllRanges();
    selection.addRange(range);
  }

  ////////////////////////////////////////
  //         Shift functions           //
  //////////////////////////////////////

  menuItems.forEach((menuItem, index) => {
    if (menuItem.line === "") {
      // Add a line separator "hr"
      const hr = document.createElement("hr");
      hr.className = "context-menu-line";
      hr.style.margin = "0";
      hr.style.padding = "0";
      contextMenu.appendChild(hr);
    } else if (menuItem.gap === "") {
      // Add a line gap "div"
      const div = document.createElement("div");
      div.className = "context-menu-gap";
      div.style.height = "8px";
      div.style.width = "10px";
      contextMenu.appendChild(div);
    } else {
      const menuItemElement = document.createElement("a");
      menuItemElement.innerText = menuItem.text;
      menuItemElement.href = menuItem.link;
      menuItemElement.className = "context-menu-item";
      menuItemElement.style.padding = "16px"; // Add padding
      menuItemElement.style.color = "black"; // Set text color to black
      menuItemElement.style.textDecoration = "none"; // Remove underline
      menuItemElement.style.transition = "color 0.3s ease"; // Add hover transition

      // Add keyboard shortcut
      if (menuItem.shortcut) {
        const shortcut = document.createElement("span");
        shortcut.innerText = menuItem.shortcut;
        shortcut.className = "keyboard-shortcut";
        menuItemElement.appendChild(shortcut);
        // styles for the shortcut
        shortcut.style.float = "right";
        shortcut.style.fontSize = "10px"; // Adjust the font size as needed
        shortcut.style.color = "#777"; // Adjust the color as needed
        shortcut.style.margin = "2px 10px"; // Add some spacing between text and shortcut
      }

      // Add click event for custom actions
      if (menuItem.action) {
        menuItemElement.addEventListener("click", e => {
          e.preventDefault();
          menuItem.action();
          hideContextMenu();
        });
      }

      // Add hover effect
      menuItemElement.addEventListener("mouseenter", () => {
        menuItemElement.style.color = "#1d92ccd1"; // Change text color on hover
      });

      // remove hover effect
      menuItemElement.addEventListener("mouseleave", () => {
        menuItemElement.style.color = "black"; // Restore original text color on hover out
      });

      contextMenu.appendChild(menuItemElement);

      // Add a line break after each item except the last one
      if (index < menuItems.length - 1 && menuItems[index + 1].line !== "") {
        const br = document.createElement("br");
        contextMenu.appendChild(br);
      }
    }
  });

  // Append the context menu to the body
  document.body.appendChild(contextMenu);

  // Prevent the context menu from appearing
  document.addEventListener("contextmenu", event => {
    event.preventDefault();
  });
}

// Function to hide the context menu
function hideContextMenu() {
  const contextMenu = document.querySelector(".context-menu");
  if (contextMenu) {
    contextMenu.remove();
  }
}

// Attach the context menu to a specific element or the entire document
document.addEventListener("contextmenu", showContextMenu);

// Add a click event listener to hide the context menu when clicking anywhere on the page
document.addEventListener("click", hideContextMenu);
