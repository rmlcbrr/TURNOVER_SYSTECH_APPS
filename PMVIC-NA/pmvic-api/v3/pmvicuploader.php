<?php


    define('TIMEZONE', 'ASIA/MANILA');
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', 600); 

    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Method: GET');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorozation, X-Request-With');

    $url = "https://pmvic.api.lto.direct/ords/dl_interfaces/interface_PMVIC/v3/store_testresults";

    $requestMethod = $_SERVER["REQUEST_METHOD"];
    $inputData = json_decode(file_get_contents("php://input"), TRUE);
    
    if($requestMethod == 'POST'){

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
        "Accept: application/json",
        "Content-Type: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $datas = json_encode($inputData, JSON_PRETTY_PRINT);

        curl_setopt($curl, CURLOPT_POSTFIELDS,  $datas);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($resp, true);

        echo json_encode($data);
    }else{
        $data = [
            'status' => 405,
            'message' => $requestMethod. ' Method Not Allowed',
        ];
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode($data);
    }