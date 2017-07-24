<?php
if(isset($_POST["url"])){
	echo is_website_up($_POST["url"]);
}else{
	echo 'false';
}

function is_website_up($url){
	//initialize curl
	$handle = curl_init($url);
	curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($handle,CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($handle,CURLOPT_HEADER,true);
	curl_setopt($handle,CURLOPT_NOBODY,true);
	curl_setopt($handle,CURLOPT_RETURNTRANSFER,true);
	//invoke curl to check the page return
	$response = curl_exec($handle);
	//optional: you may get the http status code for custom implementation
	$http_code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
	
	//close the curl handle
	curl_close($handle);
	//return the status to caller
	if ($http_code == 200 || $http_code == 300 || $http_code == 301 || $http_code == 302)
		return 'true';
	else
		return 'false';
}

/* -- outdated function

function isSiteAvailable($url){

    //make the connection with curl
	$cl = curl_init($url);
	curl_setopt($cl,CURLOPT_CONNECTTIMEOUT,10);
	curl_setopt($cl,CURLOPT_HEADER,true);
	curl_setopt($cl,CURLOPT_NOBODY,true);
	curl_setopt($cl,CURLOPT_RETURNTRANSFER,true);

 	//get response
	$response = curl_exec($cl);

	curl_close($cl);

	if ($response) return 'true';

	return 'false';
}

*/