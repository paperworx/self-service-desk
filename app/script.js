var processing = false;

function loadPage(page, post, args) {
  var dir = "/app/pages/";
  var file = dir + page + ".php";

  if(post) {
    if(processing) {
      console.error("Tried to scan another card while processing!");
      return;
    }

    processing = true;

    if(page == "login") {
      $("#scancardinfo").text("Processing");
    }

    $.post(file, args, function(data, status) {
      processing = false;

      $("#page").html(data);

      if(page == "login") {
        refocusInput();
      }
    });
  } else {
    $("#page").load(file, function() {
      if(page == "login") {
        refocusInput();
      }
    });
  }
}

function refocusInput() {
  $("#scancard").focus();
  $("#scancard").blur(function() {
    setTimeout(function() {
      $("#scancard").focus();
    }, 50);
  });
}

$(document).ready(function() {
  loadPage(curpage);
  refocusInput();
});