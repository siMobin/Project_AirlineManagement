// $

var ctx = document.getElementById("class$").getContext("2d");

// Calculate total earnings for each class
var totalEarnings = data.reduce(function (acc, item) {
  return acc + parseFloat(item.total_earnings);
}, 0);

// Sort the data by total earnings in descending order
data.sort(function (a, b) {
  return b.total_earnings - a.total_earnings;
});

var labels = data.map(function (item) {
  return item.class;
});
var earnings = data.map(function (item) {
  return item.total_earnings;
});

var mostEarningClass = data[0].class;
var mostEarningClassEarnings = data[0].total_earnings;

var halfCircleChart = new Chart(ctx, {
  type: "doughnut",
  data: {
    labels: labels,
    datasets: [
      {
        data: earnings,
        backgroundColor: ["rgba(255, 99, 132, 0.7)", "rgba(54, 162, 235, 0.7)", "rgba(255, 206, 86, 0.7)", "rgba(75, 192, 192, 0.7)", "rgba(153, 102, 255, 0.7)"],
      },
    ],
  },
  options: {
    responsive: true,
    tooltips: {
      callbacks: {
        label: function (tooltipItem, data) {
          return data.labels[tooltipItem.index];
        },
      },
    },
  },
});

// Display the most earning class
var mostEarningClassElement = document.getElementById("mostEarningClass");
mostEarningClassElement.textContent = "Most Earning Class: " + mostEarningClass + " (Earnings: " + mostEarningClassEarnings.toFixed(2) + ")";
