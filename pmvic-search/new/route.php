<?php
session_start();
require_once 'Classes/Credential.php';
require_once 'Classes/Db.php';
include('autoload.php');

use Classes\Credential;
use Classes\Db;

$credential = new Credential();
$db         = new Db();
$conn       = $db->connect($credential);
$ltms       = new Ltms($conn);
$route = isset($_POST['route']) ? $_POST['route'] : '';

//post request
switch ($route) {
    case 'login':
        if ($res = $ltms->loginForm($_POST)) {
            $_SESSION['user_id'] = $res['user_id'];
            $_SESSION['loggedin'] = 'loggedin';
            $_SESSION['start'] = time(); // Taking now logged in time.
            // Ending a session in 30 minutes from the starting time.
            $_SESSION['expire'] = $_SESSION['start'] + (600 * 60);

            echo json_encode([
                'message' => 'Success Login',
                'status'  => 200
            ]);
        }
    break;
    case 'search':
        if(isset($_POST['key'])) 
        {
            $res = $ltms->searchForm($_POST['key']);
        }
    break; 
}