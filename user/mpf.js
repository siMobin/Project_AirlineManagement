$(document).ready(function () {
  $("#class_select")
    .change(function () {
      var selectedClass = $(this).val();
      $.ajax({
        url: "mpf_data.php", // Find data from DB
        method: "POST",
        data: {
          selected_class: selectedClass,
        },
        success: function (data) {
          $("#table-container").html(data);
        },
      });
    })
    .change(); // Trigger change event after page loads
});
