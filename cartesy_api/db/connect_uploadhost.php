<?php
$username='v1-testing';
$password='0VbUN6TTDp8rjNyzv9G6';
$host='127.0.0.1';
$db='v1-testing';
$port = 3306;
$conn = new mysqli($host,$username,$password,$db,$port);

// Check connection
if ($conn -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}else{
	//echo "connected";
}

    //db credentials
   // define('DB_HOST','127.0.0.1');
   // define('DB_NAME','v1-testing');
   // define('DB_PASS','0VbUN6TTDp8rjNyzv9G6');
   // define('DB_USER','v1-testing');
    //define('DB_PORT','3306');

    //app configuration
   // define("WWW_ROOT", '/public/');
   // define("APP_NAME", 'PMVIC');