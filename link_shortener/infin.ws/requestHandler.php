<?php
header('Access-Control-Allow-Origin: *');  
if(isset($_POST['url'])){
	include_once 'config.php';
	$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
	if ($mysqli->connect_error) {
    	echo 'Error connecting to database';
    	exit();
	}

	//First we check if the url is already present in the database
	if($result = $mysqli->query("SELECT shorturl FROM `urls` WHERE longurl='" . $_POST['url'] . "';")){
		if($result->num_rows > 0){
			$array = $result->fetch_array(MYSQLI_NUM);
			echo $array[0];
			exit();
		}
	}else{
		echo "false";
		exit();
	}

	//Getting the max value of ID on the table
	if($result = $mysqli->query("SELECT max(id) AS max FROM `urls`;")){
		$array = $result->fetch_array(MYSQLI_ASSOC); //$array['max'] is the max id
		$newId = $array['max'] + 1;
		//validating entered url
		$longUrl = (preg_match('@^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$@', $_POST['url']) ? $_POST['url'] : false);
		if(!$longUrl){
			echo "false";
			exit();
		}
		$shortUrl = DOMAIN . "/" . toBase($newId, 62);
		if($result = $mysqli->query("INSERT INTO urls(longurl, shorturl) VALUES ('" . $longUrl . "','" . $shortUrl . "');")){
			echo $shortUrl;
			exit();
		}else{
			echo "false";
			exit();
		}

	}else{
		echo "false";
		exit();
	}
}else{
	echo 'false';
	exit();
}

function toBase($num, $b=62) {
  $base='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $r = $num  % $b ;
  $res = $base[$r];
  $q = floor($num/$b);
  while ($q) {
    $r = $q % $b;
    $q =floor($q/$b);
    $res = $base[$r].$res;
  }
  return $res;
}

function to10( $num, $b=62) {
  $base='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $limit = strlen($num);
  $res=strpos($base,$num[0]);
  for($i=1;$i<$limit;$i++) {
    $res = $b * $res + strpos($base,$num[$i]);
  }
  return $res;
}