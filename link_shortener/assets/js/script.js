//Make it so that pressing enter on the input simulates a button click
$(document).ready(function() {
  $("#url_input").keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      $('#url_input_button').click();
      return false;
    }
  });
});


function shortenUrl(url){
	//Remove any result message that is being displayed
	$(".result_message").animate({"opacity": 0}, 0).html("Shortening...").animate({"opacity": 1}, 500);

	if(validUrl(url)){
      if(url.search('http://www') === 0 || url.search('https://www') === 0){
        url = url;
      }else if(url.search('www') === 0){
        //If it has www but not http
        url = 'http://' + url;
      }else if(url.search('http://') === 0 || url.search('https://') === 0){
        //If it has http but not www
        if(url.search('http://') === 0){
          url = 'http://www.' + url.substring(7);
        }
        //If it has https but not www
        if(url.search('https://') === 0){
          url = 'https://www.' + url.substring(8);
        }
      }else{
        //If it doesn't have neither http nor www
        url = 'http://www.' + url;
      }
    
		$(".url_input_group").removeClass("has-error");
		$(".url_input_label").html("")
		shortenUrl_part2(url);
	}else{
		$(".url_input_group").addClass("has-error");
		$(".url_input_label").html("Invalid URL").animate({"opacity": 1}, 500);
		$(".result_message").animate({"opacity": 0}, 0);
	}
}

function shortenUrl_part2(url){
	// variable to hold request
	var request;
    // abort any pending request
    if (request) {
    	request.abort();
    }
    // fire off the request to /form.php
    request = $.ajax({
    	url: "http://www.infin.ws/requestHandler.php",
    	type: "POST",
    	data: { url: url}
    });

    // callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
    	returnResponse(response, url);
    });

    // callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
    	$(".result_message").html('Error - No response from server. Please try again later. <br> If this problem persists, please contact an administrator.');
    	return false;
    });
}

function returnResponse(response, url){
	if(response == 'false'){
    $(".result_message").html(htmlEntities(url) + ' could not be shortened. Please try again.');
	}else{
		$(".result_message").html('Your link has been shortened! Your short url is: <span id="shorturl">' + response + '</span>');
	}
}

function validUrl(str) {
  var regex = /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/;
  if(!regex.test(str)){ 
    return false; 
  }else{
    return true;
  }
}

function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}