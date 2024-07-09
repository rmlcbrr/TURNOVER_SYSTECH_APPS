<?php
class Ltms
{

    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function loginForm($data)
    {
        $newPass = md5($data['password']);

        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_user WHERE username=:username AND password=:password LIMIT 01");
            $stmt->execute([
                'username' => $data['username'],
                'password' => $newPass
            ]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                echo json_encode([
                    'message' => 'Invalid Username & Password',
                    'status'  => 400
                ]);
                die();
            }

            return $result;
        } catch (Exception $e) {
            echo json_encode([
                'message' => $e->getMessage(),
                'status'  => 500
            ]);
            die();
        }
    }

    public function searchForm($plateno)
    {
        $typePlate = strlen($plateno) > 9 ? 'mv_file_no' : 'plate_no';

        $json_arr = [$typePlate => $plateno];
        $url = "https://pmvic.api.lto.direct/ords/dl_interfaces/interface_PMVIC/v3/get_vehicleinfo";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Accept: application/json",
            "Content-Type: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = json_encode($json_arr, JSON_PRETTY_PRINT);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($resp, true);

        if($data == null) {
            echo json_encode([
                'message' => 'No Data Found OR LTMS Problem.',
                'status'  => 500
            ]);
            die();
        }

        echo json_encode([
            'message' => $data,
            'status'  => 200
        ]);  
    }
}
