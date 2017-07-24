$(document).ready(function() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      $('#url_input_button').click();
      return false;
    }
  });
});

function validateInput(url){
	//Remove any result message that is being displayed
	$(".result_message").animate({"opacity": 0}, 0).html("Checking...").animate({"opacity": 1}, 500);

	if(validUrl(url)){
		$(".url_input_group").removeClass("has-error");
		$(".url_input_label").html("")
		isWebsiteUp(url);
	}else{
		$(".url_input_group").addClass("has-error");
		$(".url_input_label").html("Invalid URL").animate({"opacity": 1}, 500);
		$(".result_message").animate({"opacity": 0}, 0);
	}
}

function isWebsiteUp(url){
	// variable to hold request
	var request;
    // abort any pending request
    if (request) {
    	request.abort();
    }
    // fire off the request to /form.php
    request = $.ajax({
    	url: "assets/php/script.php",
    	type: "post",
    	data: "url=" + url
    });

    // callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
    	returnResponse(response, url);
    });

    // callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
    	alert("The following error occured: " + textStatus + " - " + errorThrown);
    	return false;
    });
}

function returnResponse(response, url){
	if(response == 'true'){
		$(".result_message").html(htmlEntities(url) + ' is <span class="online">ONLINE</span>!');
	}else{
		$(".result_message").html(htmlEntities(url) + ' is <span class="offline">OFFLINE</span>!');
	}
}

function validUrl(str) {
  var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
  '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
  '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
  '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
  '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
  '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
  if(!pattern.test(str)) {
    return false;
  } else {
    return true;
  }
}

function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}