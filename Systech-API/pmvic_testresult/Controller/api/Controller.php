<?php
require_once '../spl_loader.php';

$auth = new Auth_Token();

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    $token = $_GET['token'] ?? null;
    $userId = $_GET['user_id'] ?? null;

    if ($auth->validateToken($userId, $token) > 0) {
        new APIHandler();
        $ini = new Initialize();
        $settings = new Settings();
        $model = new Model($ini, $settings);

        $inputData = json_decode(file_get_contents("php://input"), TRUE);

        $res = $model->processPostRequest($inputData);

        echo json_encode($res, JSON_PRETTY_PRINT);
    } else {
        http_response_code(401);
        echo json_encode(['Error' => 'Unauthorized'], JSON_PRETTY_PRINT);
    }
}
