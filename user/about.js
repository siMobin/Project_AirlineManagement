const pdfFile = "../Documents/Project Proposal_DSA II.pdf"; // file

function loadAndDisplayPDF(pdfFile) {
  const pdfContainer = document.getElementById("pdf-container");

  // Initialize PDF.js
  pdfjsLib.getDocument(pdfFile).promise.then(function (pdf) {
    for (let pageNumber = 1; pageNumber <= pdf.numPages; pageNumber++) {
      pdf.getPage(pageNumber).then(function (page) {
        const viewport = page.getViewport({ scale: 1 });
        const canvas = document.createElement("canvas");
        const context = canvas.getContext("2d");
        canvas.height = viewport.height;
        canvas.width = viewport.width;

        const renderContext = {
          canvasContext: context,
          viewport: viewport,
        };

        // Render the page as an image
        page.render(renderContext).promise.then(function () {
          pdfContainer.appendChild(canvas);
        });
      });
    }
  });
}
// Load and display the PDF
loadAndDisplayPDF(pdfFile);

/////////////////////////////////////////////////

// embedded nav bar
fetch("./nav.php")
  .then(response => response.text())
  .then(content => {
    document.getElementById("embeddedNav").innerHTML = content;
  });

// embedded footer
fetch("./footer.html")
  .then(response => response.text())
  .then(content => {
    document.getElementById("embeddedFooter").innerHTML = content;
  });
