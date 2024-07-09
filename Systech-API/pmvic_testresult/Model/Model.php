<?php
class Model extends Db
{
    public $ini;
    public $settings;

    public function __construct($ini, $settings)
    {
        $this->ini = $ini;
        $this->settings = $settings;
    }

    public function processPostRequest($inputData)
    {
        foreach ($inputData['vehicles'] as $pss_json) {
            $this->ini->MODE = $pss_json['MODE'];
            $this->ini->QUEUE_ID = $pss_json['QUEUE_ID'];
            $this->ini->INSPECTOR_USERNAME = $pss_json['INSPECTOR_USERNAME'];
            $this->ini->STAGE_NO = $pss_json['STAGE_NO'];
            $this->ini->TRANSACTION_NO = $pss_json['TRANSACTION_NO'];
            $this->ini->INSPECTION_REF_NO = $pss_json['INSPECTION_REF_NO'];
            $this->ini->PURPOSE = $pss_json['PURPOSE'];
            $this->ini->PMVIC_CENTER = $pss_json['PMVIC_CENTER'];
            $this->ini->PLATE_NUM = $pss_json['PLATE_NUM'];
            $this->ini->MV_FILE = $pss_json['MV_FILE'];
            $this->ini->CHASIS_NUM = $pss_json['CHASIS_NUM'];
            $this->ini->ENGINE_NUM = $pss_json['ENGINE_NUM'];
            $this->ini->INSPECTION_ID = $pss_json['INSPECTION_ID'];
            $this->ini->NOISE = json_encode($pss_json['NOISE']);
            $this->ini->EMISSIONS = json_encode($pss_json['EMISSIONS']);
            $this->ini->OPACITY = json_encode($pss_json['OPACITY']);
            $this->ini->LIGHTS = json_encode($pss_json['LIGHTS']);
            $this->ini->SIDESLIP = json_encode($pss_json['SIDESLIP']);
            $this->ini->SUSPENSION = json_encode($pss_json['SUSPENSION']);
            $this->ini->BRAKES = json_encode($pss_json['BRAKES']);
            $this->ini->SPEEDOMETER = json_encode($pss_json['SPEEDOMETER']);
            $this->ini->DEFECTS = json_encode($pss_json['DEFECTS']);
            $this->ini->DATE_CREATED = date("Y-m-d H:i:s");
            

            $extracted_vinfo = json_encode($pss_json['VEHICLE_INFORMATION']);

            $this->ini->VEHICLE_INFORMATION = $extracted_vinfo;
        }

        return $this->checkData();
    }
    

    public function checkData()
    {
        try {
            $sql = "SELECT * FROM tbl_dermalog WHERE (uploaded is null or uploaded=1) AND TRANSACTION_NO=:TRANSACTION_NO AND MV_FILE=:MV_FILE AND DATE_CREATED=:DATE_CREATED AND  isDeleted = '0'";
            $stmt = $this->connect()->prepare($sql);

            $stmt->bindParam(':TRANSACTION_NO', $this->ini->TRANSACTION_NO);
            $stmt->bindParam(':MV_FILE', $this->ini->MV_FILE);
            $stmt->bindParam(':DATE_CREATED', $this->ini->DATE_CREATED);
            $stmt->execute();
			
            if ($stmt->rowCount() == 0) {
              if(strlen($this->ini->MV_FILE) == 15){
                $getI_ID = $this->getSearchData();
              	$this->ini->INSPECTION_ID = $getI_ID;
                
                if ($getI_ID && $getI_ID != null) {
                  	
                    return $this->saveData();

                }else{
                  
                  $this->saveData();

                  
                  $passError = [
                      'message' => "No Data Found, Please Check in LTMS",
                      "status"  => 404
                  ];

                 return $this->getError($passError);
                  	
                }
              }else{

                $passError = [
                    'message' => "Incorrect MV FILE Format: ".$this->ini->MV_FILE ." Please Check!!!",
                    "status"  => 422
                ];

                return $this->getError($passError);
              }
                     
            } else {

                $passError = [
                    'message' => "Duplicate Data MVISR : ".$this->ini->TRANSACTION_NO,
                    "status"  => 409
                ];
                return $this->getError($passError);
            }
        } catch (Exception $e) {
            return [
                'message' => "Check Data Query: " . $e->getMessage(),
                "status"  => 500
            ];
        }
    }

    public function getSearchData()
    {
        $josn_mvfile = ['mv_file_no' =>  $this->ini->MV_FILE];

        $catch_data = $this->sendToAPI($josn_mvfile);

         return isset($catch_data["Inspection_ID"]) ? $catch_data["Inspection_ID"] : null;

        //return true; // remove later for testing porposes
    }

   

    public function saveData()
    {
        try {
            $sql = "INSERT INTO tbl_dermalog (DATE_CREATED ,MODE, QUEUE_ID, PLATE_NUM, MV_FILE, CHASIS_NUM, ENGINE_NUM, INSPECTION_ID, INSPECTOR_USERNAME, STAGE_NO, INSPECTION_REF_NO, TRANSACTION_NO, PURPOSE,PMVIC_CENTER,ITP_CODE, VEHICLE_INFORMATION, NOISE, EMISSIONS, OPACITY, LIGHTS, SIDESLIP, SUSPENSION, BRAKES, SPEEDOMETER,DEFECTS, uploaded,ERROR_LOG) 
            VALUES (:DATE_CREATED ,:MODE, :QUEUE_ID, :PLATE_NUM, :MV_FILE, :CHASIS_NUM, :ENGINE_NUM, :INSPECTION_ID, :INSPECTOR_USERNAME, :STAGE_NO, :INSPECTION_REF_NO, :TRANSACTION_NO, :PURPOSE, :PMVIC_CENTER, :ITP_CODE, :VEHICLE_INFORMATION, :NOISE, :EMISSIONS, :OPACITY, :LIGHTS, :SIDESLIP, :SUSPENSION, :BRAKES, :SPEEDOMETER,:DEFECTS, :uploaded, :ERROR_LOG)";
            $stmt = $this->connect()->prepare($sql);

            $uploaded = 1;

            // 0 - new up
            // 1 - old up

            $stmt->bindParam(':MODE', $this->ini->MODE);
            $stmt->bindParam(':QUEUE_ID', $this->ini->QUEUE_ID);
            $stmt->bindParam(':PLATE_NUM', $this->ini->PLATE_NUM);
            $stmt->bindParam(':MV_FILE', $this->ini->MV_FILE);
            $stmt->bindParam(':CHASIS_NUM', $this->ini->CHASIS_NUM);
            $stmt->bindParam(':ENGINE_NUM', $this->ini->ENGINE_NUM);
            $stmt->bindParam(':INSPECTION_ID', $this->ini->INSPECTION_ID);
            $stmt->bindParam(':INSPECTOR_USERNAME', $this->ini->INSPECTOR_USERNAME);
            $stmt->bindParam(':STAGE_NO', $this->ini->STAGE_NO);
            $stmt->bindParam(':INSPECTION_REF_NO', $this->ini->INSPECTION_REF_NO);
            $stmt->bindParam(':TRANSACTION_NO', $this->ini->TRANSACTION_NO);
            $stmt->bindParam(':PURPOSE', $this->ini->PURPOSE);
            $stmt->bindParam(':PMVIC_CENTER', $this->ini->PMVIC_CENTER);
            $stmt->bindParam(':ITP_CODE', $this->ini->ITP_CODE);
            $stmt->bindParam(':VEHICLE_INFORMATION', $this->ini->VEHICLE_INFORMATION);
            $stmt->bindParam(':NOISE', $this->ini->NOISE);
            $stmt->bindParam(':EMISSIONS', $this->ini->EMISSIONS);
            $stmt->bindParam(':OPACITY', $this->ini->OPACITY);
            $stmt->bindParam(':LIGHTS', $this->ini->LIGHTS);
            $stmt->bindParam(':SIDESLIP', $this->ini->SIDESLIP);
            $stmt->bindParam(':SUSPENSION', $this->ini->SUSPENSION);
            $stmt->bindParam(':BRAKES', $this->ini->BRAKES);
            $stmt->bindParam(':SPEEDOMETER', $this->ini->SPEEDOMETER);
            $stmt->bindParam(':DEFECTS', $this->ini->DEFECTS);
            $stmt->bindParam(':uploaded', $uploaded);
         	$stmt->bindParam(':ERROR_LOG', $this->ini->ERROR_LOG);
            $stmt->bindParam(':DATE_CREATED', $this->ini->DATE_CREATED);

            $this->ini->MODE = $this->ini->MODE;
            $this->ini->PLATE_NUM = $this->ini->PLATE_NUM;
            $this->ini->QUEUE_ID = $this->ini->QUEUE_ID;
            $this->ini->MV_FILE = $this->ini->MV_FILE;
            $this->ini->CHASIS_NUM = $this->ini->CHASIS_NUM;
            $this->ini->ENGINE_NUM = $this->ini->ENGINE_NUM;
            $this->ini->INSPECTION_ID = $this->ini->INSPECTION_ID;
            $this->ini->INSPECTOR_USERNAME = $this->ini->INSPECTOR_USERNAME;
            $this->ini->STAGE_NO = $this->ini->STAGE_NO;
            $this->ini->INSPECTION_REF_NO = $this->ini->INSPECTION_REF_NO;
            $this->ini->TRANSACTION_NO = $this->ini->TRANSACTION_NO;
            $this->ini->PURPOSE = $this->ini->PURPOSE;
            $this->ini->PMVIC_CENTER = $this->ini->PMVIC_CENTER;
            $this->ini->ITP_CODE = $this->ini->ITP_CODE;
            $this->ini->VEHICLE_INFORMATION = $this->ini->VEHICLE_INFORMATION;
            $this->ini->NOISE = $this->ini->NOISE;
            $this->ini->EMISSIONS = $this->ini->EMISSIONS;
            $this->ini->OPACITY = $this->ini->OPACITY;
            $this->ini->LIGHTS = $this->ini->LIGHTS;
            $this->ini->SIDESLIP = $this->ini->SIDESLIP;
            $this->ini->SUSPENSION = $this->ini->SUSPENSION;
            $this->ini->BRAKES = $this->ini->BRAKES;
            $this->ini->SPEEDOMETER = $this->ini->SPEEDOMETER;
            $this->ini->DEFECTS = $this->ini->DEFECTS;
            $uploaded = $uploaded;
          	$this->ini->ERROR_LOG = $this->ini->ERROR_LOG;
            $this->ini->DATE_CREATED = $this->ini->DATE_CREATED;

            $stmt->execute();

            //  return [
            //      'message' => "Data save.",
            //      "status"  => 200
            //  ];

            return $this->searchData();
        } catch (Exception $e) {
            return [
                'message' => "Save Data Query: " . $e->getMessage(),
                "status"  => 500
            ];
        }
    }

    public function searchData()
    {
        try {
            $sql = "SELECT * FROM tbl_dermalog WHERE (status is null or status='') AND TRANSACTION_NO=:TRANSACTION_NO order by id desc limit 1";
            $stmt = $this->connect()->prepare($sql);

            $stmt->bindParam(':TRANSACTION_NO', $this->ini->TRANSACTION_NO);

            $stmt->execute();

            $json_data = "";

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    //$this->getSearchData()

                 
                $json_data = '{    
                    "MODE" : "' . $row['MODE'] . '", 
                    "QUEUE_ID"  : "" ,
                    "INSPECTION_ID" :"' .$row['INSPECTION_ID'] . '",  
                    "INSPECTOR_USERNAME" : "' . $row['INSPECTOR_USERNAME'] . '", 
                    "STAGE_NO" : "' . $row['STAGE_NO'] . '", 
                    "INSPECTION_REF_NO" : "' . $row['INSPECTION_REF_NO'] . '",  
                    "TRANSACTION_NO ": "' . $row['TRANSACTION_NO'] . '",  
                    "PURPOSE" : "' . $row['PURPOSE'] . '",  
                    "PMVIC_CENTER" : "' . $row['PMVIC_CENTER'] . '",  
                    "ITP_CODE":  "Sys", 
                    "VEHICLE_INFORMATION" :  ' . ($row['VEHICLE_INFORMATION']) . ', 
                    "NOISE" :' . ($row['NOISE']) . ', 
                    "EMISSIONS" : ' . ($row['EMISSIONS']) . ', 
                    "OPACITY" : ' . ($row['OPACITY']) . ', 
                    "LIGHTS" : ' . ($row['LIGHTS']) . ',
                    "SIDESLIP" :' . ($row['SIDESLIP']) . ', 
                    "SUSPENSION" : ' . ($row['SUSPENSION']) . ', 
                    "BRAKES" :  ' . ($row['BRAKES']) . ',                                      
                    "SPEEDOMETER"  : ' . ($row['SPEEDOMETER']) . ',
                    "DEFECTS" : ' . ($row['DEFECTS']) . '
                } ';
            }

           
           // return $this->testSaveDataToApi($json_data);
          
           return $this->saveDataToApi($json_data);
          
        } catch (Exception $e) {
            return [
                'message' => "Search Data Query: " . $e->getMessage(),
                "status"  => 500
            ];
        }
    }

    public function testSaveDataToApi($json_data) //test save api response
    {
        $response = "SUCCESS";

        $json_file = '{"RESPONSE":"SUCCESS","DATE_SENT":"2023-11-21T09:13:13","PMVIC_MANAGER":"","INSPECTION_REFERENCE_NO":"202311210002","OVERALL_EVALUATION":-1,"PMVIC_TESTS":{"NOISE_TEST":1,"EMISSION_TEST":0,"OPACITY_TEST":1,"LIGHT_TEST":1,"SIDESLIP_TEST":1,"SPEED_TEST":1,"SUSPENSION_TEST":1,"BRAKES_TEST":1,"VISUAL_DEFECTS_FOUND":1},"LTO_EVALUATION":{"NOISE_TEST":{"PIPE1":{"ENGINE":1,"EXHAUST":1,"HORN":1},"NOISE_VERDICT":1},"EMISSION_TEST":{"RESULT_HC":1,"RESULT_CO":-1,"EMISSION_VERDICT":-1},"OPACITY_TEST":{"OPACITY_VERDICT":null},"LIGHT_TEST":{"LIGHT_VERDICT":1},"SIDESLIP_TEST":{"AXLE1":1,"AXLE2":1,"SIDESLIP_VERDICT":1},"SPEED_TEST":{"SPEED1":-1,"SPEEDOMETER_VERDICT":-1},"SUSPENSION_TEST":{"AXLE1":{"LEFT":1,"RIGHT":1},"AXLE2":{"LEFT":1,"RIGHT":1},"SUSPENSION_VERDICT":1},"BRAKES_TEST":{"AXLE1":{"SERVICE":{"DIFFERENCE":1}},"AXLE2":{"SERVICE":{"DIFFERENCE":1}},"PARKING_EFFICIENCY":null,"SERVICE_EFFICIENCY":1,"BRAKES_VERDICT":1},"DEFECTS_EVALUATION":{"VISUAL_VERDICT":-1}}}';

        if ($response == "SUCCESS") {

            try {
                $sql = "UPDATE tbl_dermalog SET status='OK', SUCCESS_LOG = 'SUCCESS', OVERALL_EVALUATION =:OVERALL_EVALUATION WHERE TRANSACTION_NO=:TRANSACTION_NO";

                $stmt = $this->connect()->prepare($sql);

                $stmt->bindParam(':OVERALL_EVALUATION', $json_file);
                $stmt->bindParam(':TRANSACTION_NO', $this->ini->TRANSACTION_NO);
                $result = $stmt->execute();

                if ($result) {
                    return [
                        'message'  => "OK",
                        'response' => $response,
                        "status"   => 200
                    ];
                } else {
                    return [
                        'message'  => "No Response",
                        "status"   => 204
                    ];
                }
            } catch (Exception $e) {
                return [
                    'message' => "Save Data To Api Query: " . $e->getMessage(),
                    "status"  => 500
                ];
            }
        } else {
            return [
                'message'  => "Not Modified",
                'response' => $response,
                "status"   => 304
            ];
        }
    }

    public function saveDataToApi($json_data)
    {
        $url = $this->settings->url_lvl_2;

        $sOutput = "";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        $sOutput = curl_exec($ch);

        curl_close($ch);

        $response = json_decode($sOutput, true);
       
        $json_file = json_encode($response);

        if(empty($response)){

            $passError = [
                    "message"  => "API Return Bad Request, Please Check Network!",
                    "status"   => 400
                ];
                return $this->getError($passError);
            
            
        }
        
        
        if ($response["RESPONSE"] == "Success" || $response["RESPONSE"] == "SUCCESS") {

            try {
                $sql = "UPDATE tbl_dermalog SET status='OK', SUCCESS_LOG = 'SUCCESS', OVERALL_EVALUATION =:OVERALL_EVALUATION WHERE TRANSACTION_NO=:TRANSACTION_NO";

                $stmt = $this->connect()->prepare($sql);

                $stmt->bindParam(':OVERALL_EVALUATION', $json_file);
                $stmt->bindParam(':TRANSACTION_NO', $this->ini->TRANSACTION_NO);
                $result = $stmt->execute();

                if ($result) {
                    return [
                        'message'  => "OK",
                        'response' => $response["RESPONSE"],
                        "status"   => 200
                    ];
                } else {
                    return [
                        'message'  => "No Response",
                        "status"   => 204
                    ];
                }
            } catch (Exception $e) {
                return [
                    'message' => "Save Data To Api Query: " . $e->getMessage(),
                    "status"  => 500
                ];
            }
        } else {
            return [
                'message'  => "Not Modified",
                'response' => $response["RESPONSE"],
                "status"   => 304
            ];
        }
    }

    public function sendToAPI($json_data)
    {
        $url = $this->settings->url_lvl_1;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Accept: application/json",
            "Content-Type: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = json_encode($json_data, JSON_PRETTY_PRINT);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);

        return json_decode($resp, true);
    }

    public function getError($passError){
 
        $error_log = json_encode($passError);
        $sql = "UPDATE tbl_dermalog SET ERROR_LOG=:ERROR_LOG WHERE TRANSACTION_NO=:TRANSACTION_NO";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':ERROR_LOG', $error_log);
        $stmt->bindParam(':TRANSACTION_NO', $this->ini->TRANSACTION_NO);
        $result = $stmt->execute();

        if ($result) {
            return json_decode($error_log);
        }
        
    }
}
