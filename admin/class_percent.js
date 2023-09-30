// %
var ctx = document.getElementById("class%").getContext("2d");

var percentages = data.map(function (item) {
  return item.percentage;
});

var labels = data.map(function (item) {
  return item.class;
});

var halfCircleChart = new Chart(ctx, {
  type: "doughnut",
  data: {
    labels: labels, // Show labels by default
    datasets: [
      {
        data: percentages,
        backgroundColor: ["rgba(255, 99, 132, 0.7)", "rgba(54, 162, 235, 0.7)", "rgba(255, 206, 86, 0.7)", "rgba(75, 192, 192, 0.7)", "rgba(153, 102, 255, 0.7)"],
      },
    ],
  },
  options: {
    responsive: true,
    plugins: {
      legend: {
        display: true,
      },

      tooltips: {
        callbacks: {
          label: function (tooltipItem, data) {
            return data.labels[tooltipItem.index];
          },
        },
      },
    },
  },
});
