// default
Chart.defaults.font.size = 9;
var font = 11;
var borWidth = 0.5;

// Pilot Chart
var pilotLabels = [];
var pilotAssignmentCounts = [];
var pilotCounts = [];
var coPilotCounts = [];

for (var i = 0; i < pilotData.length; i++) {
  pilotLabels.push(pilotData[i].name);
  pilotAssignmentCounts.push(pilotData[i].assignment_count);
  pilotCounts.push(pilotData[i].pilot_count);
  coPilotCounts.push(pilotData[i].co_pilot_count);
}

var pilotCtx = document.getElementById("pilotChart").getContext("2d");
var pilotChart = new Chart(pilotCtx, {
  type: "bar",
  data: {
    labels: pilotLabels,
    datasets: [
      {
        label: "Assignment Count",
        data: pilotAssignmentCounts,
        backgroundColor: "rgba(0, 137, 142, 0.1)",
        borderColor: "rgba(0, 137, 142, 0.5)",
        borderWidth: borWidth,
      },
      {
        label: "Pilot Count",
        data: pilotCounts,
        backgroundColor: "rgba(255, 99, 132, 0.2)",
        borderColor: "rgba(255, 99, 132, 1)",
        borderWidth: borWidth,
      },
      {
        label: "Co-Pilot Count",
        data: coPilotCounts,
        backgroundColor: "rgba(54, 162, 235, 0.2)",
        borderColor: "rgba(54, 162, 235, 1)",
        borderWidth: borWidth,
      },
    ],
  },
  options: {
    plugins: {
      legend: {
        labels: {
          font: {
            size: font,
          },
        },
      },
    },
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
          text: "Pilot",
        },
      },
    },
  },
});

// Hostess Chart
var hostessLabels = [];
var hostessAssignmentCounts = [];
var hostessCounts = [];
var coHostessCounts = [];
var coHostessSecondaryCounts = [];

for (var i = 0; i < hostessData.length; i++) {
  hostessLabels.push(hostessData[i].name);
  hostessAssignmentCounts.push(hostessData[i].assignment_count);
  hostessCounts.push(hostessData[i].hostess_count);
  coHostessCounts.push(hostessData[i].co_hostess_count);
  coHostessSecondaryCounts.push(hostessData[i].co_hostess_secondary_count);
}

var hostessCtx = document.getElementById("hostessChart").getContext("2d");
var hostessChart = new Chart(hostessCtx, {
  type: "bar",
  data: {
    labels: hostessLabels,
    datasets: [
      {
        label: "Assignment Count",
        data: hostessAssignmentCounts,
        backgroundColor: "rgba(0, 137, 142, 0.1)",
        borderColor: "rgba(0, 137, 142, 0.5)",
        borderWidth: borWidth,
      },
      {
        label: "Hostess Count",
        data: hostessCounts,
        backgroundColor: "rgba(255, 206, 86, 0.2)",
        borderColor: "rgba(255, 206, 86, 1)",
        borderWidth: borWidth,
      },
      {
        label: "Co-Hostess Count",
        data: coHostessCounts,
        backgroundColor: "rgba(153, 102, 255, 0.2)",
        borderColor: "rgba(153, 102, 255, 1)",
        borderWidth: borWidth,
      },
      {
        label: "Co-Hostess Secondary Count",
        data: coHostessSecondaryCounts,
        backgroundColor: "rgba(255, 159, 64, 0.2)",
        borderColor: "rgba(255, 159, 64, 1)",
        borderWidth: borWidth,
      },
    ],
  },
  options: {
    plugins: {
      legend: {
        labels: {
          font: {
            size: font,
          },
        },
      },
    },
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
          text: "Hostess",
        },
      },
    },
  },
});
