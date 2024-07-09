<?php
    include '../../initialize.php';

    error_reporting(1);
    define('TIMEZONE', 'ASIA/MANILA');
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', 600); 

    header('Access-Control-Allow-Origin:*');
    header('Content-Tyoe: application/json');
    header('Access-Control-Allow-Method: GET');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorozation, X-Request-With');

    $requestMethod = $_SERVER["REQUEST_METHOD"];

    if($requestMethod == "POST") {
       
        $api_access = new Upload();
        $api_access->$MODE;
        $api_access->$BRANCH_ID;
        $api_access->$QUEUE_ID;
        $api_access->$INSPECTION_ID;
        $api_access->$INSPECTOR_USERNAME;
        $api_access->$STAGE_NO;
        $api_access->$INSPECTION_REF_NO;
        $api_access->$TRANSACTION_NO;
        $api_access->$PURPOSE;
        $api_access->$PMVIC_CENTER;
        $api_access->$VEHICLE_INFORMATION;
        $api_access->$NOISE;
        $api_access->$EMISSIONS;
        $api_access->$OPACITY;
        $api_access->$LIGHTS;
        $api_access->$SIDESLIP;
        $api_access->$SUSPENSION;
        $api_access->$BRAKES;
        $api_access->$SPEEDOMETER;
        $api_access->$DEFECTS;
        $result = $api_access->Save_API();

        echo json_encode($result);

    }else{

        $data = [
            'status' => 405,
            'message' => $requestMethod. ' Method Not Allowed',
        ];
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode($data);
    }