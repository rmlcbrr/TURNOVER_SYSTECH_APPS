<?php
class APIHandler {
    
    public function __construct() {
        $this->requestMethod();
        $this->setHeaders();
        $this->setPHPSettings();
    }

    private function setHeaders() {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Method: GET');
        header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
    }

    private function setPHPSettings() {
        date_default_timezone_set('Asia/Manila');
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 600);
    }

    private function requestMethod() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(["Error" => "Method Not Allowed"]);
            exit(); 
        }
    }
}