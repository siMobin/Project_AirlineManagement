// ppm
function ppm(labels, data) {
  var ctx = document.getElementById("ppm").getContext("2d");
  var myChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: labels,
      datasets: [
        {
          label: "Total Passengers",
          data: data,
          backgroundColor: "rgba(54, 162, 235, 0.2)",
          borderColor: "rgba(54, 162, 235, 1)",
          borderWidth: 1,
        },
      ],
    },
    options: {
      scales: {
        y: {
          title: {
            display: true,
            text: "Passengers",
          },
        },
        x: {
          title: {
            display: true,
            text: "Month",
          },
        },
        yAxes: [
          {
            ticks: {
              beginAtZero: true,
            },
          },
        ],
      },
    },
  });
}

// fpm//////////////
// Function to create the bar chart
function fpm(labels, data) {
  var ctx = document.getElementById("fpm").getContext("2d");
  var myChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: labels,
      datasets: [
        {
          label: "Total Flights",
          data: data,
          backgroundColor: "rgba(54, 162, 235, 0.2)",
          borderColor: "rgba(54, 162, 235, 1)",
          borderWidth: 0.5,
        },
      ],
    },
    options: {
      scales: {
        y: {
          title: {
            display: true,
            text: "Flight",
          },
        },
        x: {
          title: {
            display: true,
            text: "Month",
          },
        },
        yAxes: [
          {
            ticks: {
              beginAtZero: true,
            },
          },
        ],
      },
    },
  });
}

//cpm//////////////////
document.addEventListener("DOMContentLoaded", function () {
  var ctx = document.getElementById("cpm").getContext("2d");
  var myChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: chartData.labels,
      datasets: [
        {
          label: "Total Earnings",
          data: chartData.data,
          backgroundColor: "rgba(54, 162, 235, 0.2)",
          borderColor: "rgba(54, 162, 235, 1)",
          borderWidth: 1,
        },
      ],
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: "$ Dollar",
          },
        },
        x: {
          title: {
            display: true,
            text: "Month",
          },
        },
      },
    },
  });
});

// ppc
document.addEventListener("DOMContentLoaded", function () {
  var ctx = document.getElementById("ppc").getContext("2d");
  var lineChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: months,
      datasets: [
        {
          label: "Economy",
          data: economyData,
          borderColor: "#A52A2A",
          lineTension: 0.2,
          borderWidth: 2,
          // fill: true,
        },
        {
          label: "Business",
          data: businessData,
          borderColor: "#008000",
          lineTension: 0.2,
          borderWidth: 2,
          // fill: true,
        },
        {
          label: "First",
          data: firstData,
          borderColor: "#1d92ccd1",
          lineTension: 0.2,
          // backgroundColor: 'rgba(75, 192, 192, 0.2)',
          borderWidth: 2,
          // fill: true,
        },
      ],
    },
    options: {
      responsive: true,
      bezierCurve: false,
      scales: {
        x: {
          display: true,
          title: {
            display: true,
            text: "Month",
          },
        },
        y: {
          display: true,
          title: {
            display: true,
            text: "Passengers",
          },
        },
      },
    },
  });
});

//fba
document.addEventListener("DOMContentLoaded", function () {
  var ctx = document.getElementById("fba").getContext("2d");
  var myChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: airportNames,
      datasets: [
        {
          label: "Flight Starts",
          data: flightCountsStart,
          backgroundColor: "rgba(75, 192, 192, 0.1)",
          borderColor: "rgba(70, 192, 192, 1)",
          lineTension: 0.3,
          borderWidth: 1,
          fill: true,
          tension: 0.4,
        },
        {
          label: "Flight Destinations",
          data: flightCountsDestination,
          backgroundColor: "rgba(165, 42, 42, 0.1)",
          borderColor: "#A52A2A",
          lineTension: 0.3,
          borderWidth: 1,
          fill: true,
          tension: 0.4,
        },
      ],
    },
    options: {
      scales: {
        x: {
          display: true,
          title: {
            display: true,
            text: "Airport",
          },
        },
        y: {
          beginAtZero: true,
          stepSize: 1,
          display: true,
          title: {
            display: true,
            text: "Flight",
          },
        },
      },
    },
  });
});
