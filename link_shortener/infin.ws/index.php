<?php
if (!$_SERVER["REDIRECT_URL"]) {
	echo "Welcome to infin.ws. To create a redirect url, please go to www.infinifty.net and search for the link shortener app.";
	exit();
}else{
	include_once 'config.php';
	$shortUrl = substr($_SERVER["REDIRECT_URL"], 1); //Removes / from the url

	$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
	if ($mysqli->connect_error) {
    	echo 'Error connecting to database';
    	exit();
	}

	if($result = $mysqli->query("SELECT longurl FROM `urls` WHERE shorturl='http://www.infin.ws/" . $shortUrl . "';")){
		if($result->num_rows > 0){
			$array = $result->fetch_array(MYSQLI_NUM);
			header("HTTP/1.1 301 Moved Permanently"); 
			header("Location: " . $array[0]); 
		}else{
			echo "The requested url was not found in the database. If you believe this is a mistake, please report it to an admin.";
			exit();
		}
	}else{
		echo "Error communicating with database.";
		exit();
	}
}