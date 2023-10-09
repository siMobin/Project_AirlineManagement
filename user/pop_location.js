// show popup div in user page from nav

$(function () {
  $(".pop_location").click(function () {
    $(".cover").fadeIn("300");
  });
  $(".cover,.close").click(function () {
    $(".cover").fadeOut("300");
  });
  $(".contents").click(function (e) {
    e.stopPropagation();
  });
});
