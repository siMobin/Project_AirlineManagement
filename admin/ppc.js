var ctx = document.getElementById("passengerChart").getContext("2d");

var ctx = document.getElementById("passengerChart").getContext("2d");
// Function to generate a random color in the format "#RRGGBB"
function getRandomColor() {
  var letters = "0123456789ABCDEF";
  var color = "#";
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}

// Generate random colors for each dataset
chartData.datasets.forEach(function (dataset) {
  var randomColor = getRandomColor();
  dataset.backgroundColor = randomColor + "40"; // Adjust alpha for fill color
  dataset.borderColor = randomColor;
  (dataset.lineTension = 0.2), (dataset.borderWidth = 2);
});

var config = {
  type: "line",
  data: chartData,

  options: {
    scales: {
      x: {
        beginAtZero: true,
        title: {
          display: true,
          text: "Month",
        },
      },
      y: {
        beginAtZero: true,
        title: {
          display: true,
          text: "Passengers",
        },
      },
    },
  },
};

var myChart = new Chart(ctx, config);
