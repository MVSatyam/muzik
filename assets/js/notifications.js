$(document).ready(function () {
  setInterval(() => {
    count_notifications();
    get_notifications();
  }, 1000);

  function count_notifications() {
    $.ajax({
      url: "count_notifications.php",
      type: "post",
      success: function (result) {
        $("#notification_count").html(result);
      },
    });
  }
  function get_notifications() {
    $.ajax({
      url: "get_notifications.php",
      type: "post",
      success: function (result) {
        $("#notification-dropdown").html(result);
      },
    });
  }
});
