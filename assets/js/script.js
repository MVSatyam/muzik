$(document).on("mouseover", "#playSong", function () {
  $(this).addClass("teal-text").removeClass("white-text");
});

$(document).on("mouseleave", "#playSong", function () {
  $(this).addClass("white-text").removeClass("teal-text");
});

$(document).on("click", "#addToFavourites", function () {
  var userid = $(this).data("userid");
  var songid = $(this).data("songid");
  $.ajax({
    url: "addtofav.php",
    type: "post",
    data: "user_id=" + userid + "&song_id=" + songid,
    success: function (data) {
      toastr.success(data);
    },
  });
  $(this).empty();
  $(this).append('<i class="fas fa-heart text-success"></i>');
  $(this).removeAttr("id").attr("id", "removeFromFavourites");
});

$(document).on("click", "#removeFromFavourites", function () {
  var userid = $(this).data("userid");
  var songid = $(this).data("songid");

  $.ajax({
    url: "removefromfav.php",
    type: "post",
    data: "user_id=" + userid + "&song_id=" + songid,
    success: function (data) {
      toastr.info(data);
    },
  });
  $(this).empty();
  $(this).append('<i class="far fa-heart"></i>');
  $(this).removeAttr("id").attr("id", "addToFavourites");
});
