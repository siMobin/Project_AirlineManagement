var labels = [];
var assignmentCounts = [];
var pilotCounts = [];
var coPilotCounts = [];
var hostessCounts = [];
var coHostessCounts = [];
var coHostessSecondaryCounts = [];

for (var i = 0; i < driverData.length; i++) {
  labels.push(driverData[i].name);
  assignmentCounts.push(driverData[i].assignment_count);
  pilotCounts.push(driverData[i].pilot_count);
  coPilotCounts.push(driverData[i].co_pilot_count);
  hostessCounts.push(driverData[i].hostess_count);
  coHostessCounts.push(driverData[i].co_hostess_count);
  coHostessSecondaryCounts.push(driverData[i].co_hostess_secondary_count);
}

var ctx = document.getElementById("assignmentChart").getContext("2d");
var myChart = new Chart(ctx, {
  type: "bar",
  data: {
    labels: labels,
    datasets: [
      {
        label: "Assignment Count",
        data: assignmentCounts,
        backgroundColor: "rgba(30, 40, 40, 0.1)",
        borderColor: "rgba(30, 40, 41,0.5)",
        borderWidth: 0.5,
      },
      {
        label: "Pilot Count",
        data: pilotCounts,
        backgroundColor: "rgba(255, 99, 132, 0.2)",
        borderColor: "rgba(255, 99, 132, 1)",
        borderWidth: 0.5,
      },
      {
        label: "Co-Pilot Count",
        data: coPilotCounts,
        backgroundColor: "rgba(54, 162, 235, 0.2)",
        borderColor: "rgba(54, 162, 235, 1)",
        borderWidth: 0.5,
      },
      {
        label: "Hostess Count",
        data: hostessCounts,
        backgroundColor: "rgba(255, 206, 86, 0.2)",
        borderColor: "rgba(255, 206, 86, 1)",
        borderWidth: 0.5,
      },
      {
        label: "Co-Hostess Count",
        data: coHostessCounts,
        backgroundColor: "rgba(153, 102, 255, 0.2)",
        borderColor: "rgba(153, 102, 255, 1)",
        borderWidth: 0.5,
      },
      {
        label: "Co-Hostess Secondary Count",
        data: coHostessSecondaryCounts,
        backgroundColor: "rgba(255,159,64 ,0.2)",
        borderColor: "rgba(255,159,64 ,1)",
        borderWidth: 0.5,
      },
    ],
  },
  options: {
    scales: {
      y: {
        beginAtZero: true,
        title: {
          display: true,
          text: "Flight",
        },
      },
      x: {
        title: {
          display: true,
          text: "Name",
        },
      },
    },
  },
});
