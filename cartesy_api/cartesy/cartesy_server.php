<?php

  include_once '../db/connect_uploadhost.php';
  date_default_timezone_set('Asia/Manila');
  ini_set('memory_limit', '-1');
  ini_set('max_execution_time', 600); 

  header('Access-Control-Allow-Origin:*');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Method: GET');
  header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorozation, X-Request-With');
  $url_get_info = "https://pmvic.api.lto.direct/ords/dl_interfaces/interface_PMVIC/v3/get_vehicleinfo";
  $url_send_ltms = "https://pmvic.api.lto.direct/ords/dl_interfaces/interface_PMVIC/v3/store_testresults";

  $requestMethod = $_SERVER["REQUEST_METHOD"];
  $msg="";
  $dupmsg="";
  $errormsg="";
  $responseNew = null;
  $data = [];
  if($requestMethod == 'POST'){

    $inputData = json_decode(file_get_contents("php://input"), TRUE);

    if($inputData != null){

      foreach($inputData['vehicles'] as $pss_json){

        $query = "";
        $MODE=$pss_json['MODE'];
        $BRANCH_ID = $pss_json['BRANCH_ID'];
        $QUEUE_ID=$pss_json['QUEUE_ID'];
        $INSPECTOR_USERNAME=$pss_json['INSPECTOR_USERNAME'];
        $STAGE_NO=$pss_json['STAGE_NO'];
        $INSPECTION_REF_NO=trim($pss_json['INSPECTION_REF_NO']);
        $TRANSACTION_NO=trim($pss_json['TRANSACTION_NO']);
        $PURPOSE=$pss_json['PURPOSE'];
        $PMVIC_CENTER=$pss_json['PMVIC_CENTER'];
        $ITP_CODE = "Sys";
        $PLATE=trim($pss_json['PLATE_NUM']);
        $MV_FILE=trim($pss_json['MV_FILE']);
        $CHASSIS=trim($pss_json['CHASIS_NUM']);
        $ENGINE=trim($pss_json['ENGINE_NUM']);
        $VEHICLE_INFORMATION=json_encode($pss_json['VEHICLE_INFORMATION']);
        $NOISE=json_encode($pss_json['NOISE']);
        $LIGHTS=json_encode($pss_json['LIGHTS']);
        $SIDESLIP=json_encode($pss_json['SIDESLIP']);
        $SUSPENSION=json_encode($pss_json['SUSPENSION']);
        $BRAKES= json_encode($pss_json['BRAKES']);
        $SPEEDOMETER=json_encode($pss_json['SPEEDOMETER']);
        $DEFECTS= json_encode($pss_json['DEFECTS']);
        $BRANCH_ID=$pss_json['BRANCH_ID'];

        $query = "SELECT * FROM tbl_dermalog WHERE TRANSACTION_NO = '$TRANSACTION_NO' AND MV_FILE='$MV_FILE'";
        $result = mysqli_query($conn,$query);

        if(mysqli_num_rows($result) <= 0){
          $json_send_to_getinfo = array('mv_file_no' =>  $MV_FILE);

          $Clean_MV_FILE = str_replace(' ','',$MV_FILE);

          if(strlen($Clean_MV_FILE) == 15){

            $catch_data = sendToAPI($json_send_to_getinfo,$url_get_info);

            if($catch_data != null){
            
              $Inspection_ID = $catch_data["Inspection_ID"];
              $emission_hc = ($catch_data["Test_Limits"]["emission_hc"] == "") ? 0 : substr($catch_data["Test_Limits"]["emission_hc"], 2);
              $emission_co = ($catch_data["Test_Limits"]["emission_co"] == "") ? 0 : substr($catch_data["Test_Limits"]["emission_co"], 2);
              $opacity_k = ($catch_data["Test_Limits"]["opacity_k"] == "") ? 0 : substr($catch_data["Test_Limits"]["opacity_k"], 2);
              $Fuel_Type = $catch_data["Vehicle_Information"]["Fuel_Type"];
              $Date_Tested = date('Y/m/d H:i:s');
              $Date_Tested_end = strtotime($Date_Tested.' + 15 minute');
              $Date_Tested_end = date('Y/m/d H:i:s', $Date_Tested_end);
              
              $hc = intdiv($emission_hc, 2);
              $co = intdiv($emission_co, 2);
              
              
              
              $pipe='"Idle": {
                              "HC": '.$hc.',
                              "CO": '.$co.',
                              "CO2": 1,
                              "O2": 1,
                              "NO": 1,
                              "Lambda": 1,
                              "Oil_Temperature": 0.0,
                              "RPM": 1
                          },
                      "Fast": {
                              "HC": 1,
                              "CO": 1,
                              "CO2":1,
                              "O2": 1,
                              "NO": 1,
                              "Lambda": 1,
                              "Oil_Temperature": 0.0,
                              "RPM": 1
                              }';
      
              $pipe2 = '"Fast": {
                              "HC": 1,
                              "CO": 1,
                              "CO2":1,
                              "O2": 1,
                              "NO": 1,
                              "Lambda": 1,
                              "Oil_Temperature": 0.0,
                              "RPM": 1
                              }';
              $EMISSIONS ="";
              $EMISSIONS='{
                  "Status": {
                      "Status": 1,
                      "Remarks": "PASSED"
                  },
                  "DateTime_Start":  "'.$Date_Tested.'",
                  "DateTime_End": "'.$Date_Tested_end.'",
                  "Fuel_obj": [
                      {
                          "Fuel": "'.$Fuel_Type.'",
                          "Pipe": [
                              {
                                  '.$pipe.'
                              },
                              {
                                  '.$pipe2.'
                              }
                          ]
                      }
                  ],
                      "Result_HC": "'.$hc.'",
                      "Result_CO": "'.$co.'",
                      "Verdict": 1
                  }';
              $OPACITY="";
              $OPACITY='{
                  "DateTime_Start": "'.$Date_Tested.'",
                  "DateTime_End": "'.$Date_Tested_end.'",
                  "Pipe": [
                      {
                          "DateTime_Start": null,
                          "DateTime_End": null,
                          "K_Average":"'.$opacity_k.'",
                          "Accelerations": [
                              {
                                  "K":"'.$opacity_k.'",
                                  "RPM_Idle": 0,
                                  "RPM_Fast": 0,
                                  "Oil_Temperature": 0
                              }
                          ],
                          "Verdict": 1
                      }
                  ],
                  "Result_K": "'.$opacity_k.'",
                  "Verdict": 1
              }';
  
              $insert_new_data = "INSERT INTO tbl_dermalog ( DATE_CREATED ,MODE, QUEUE_ID, PLATE_NUM, MV_FILE, CHASIS_NUM, ENGINE_NUM, INSPECTION_ID, INSPECTOR_USERNAME, STAGE_NO, INSPECTION_REF_NO, TRANSACTION_NO, PURPOSE,PMVIC_CENTER,ITP_CODE, VEHICLE_INFORMATION, NOISE, EMISSIONS, OPACITY, LIGHTS, SIDESLIP, SUSPENSION, BRAKES, SPEEDOMETER,DEFECTS) 
                                  VALUES ('$Date_Tested','$MODE','$QUEUE_ID','$PLATE','$MV_FILE','$CHASSIS','$ENGINE','$Inspection_ID','$INSPECTOR_USERNAME','$STAGE_NO','$INSPECTION_REF_NO','$TRANSACTION_NO','$PURPOSE','$PMVIC_CENTER','$ITP_CODE','$VEHICLE_INFORMATION','$NOISE','$EMISSIONS','$OPACITY','$LIGHTS','$SIDESLIP','$SUSPENSION','$BRAKES','$SPEEDOMETER','$DEFECTS') ";
              $validate_insert = "";
              $validate_insert = mysqli_query($conn,$insert_new_data);
  
              if($validate_insert){
  
                $select_sql = "SELECT * FROM tbl_dermalog WHERE (status is null or status='') and TRANSACTION_NO='$TRANSACTION_NO' order by id desc limit 1";
                $sec_query = mysqli_query($conn, $select_sql);
  
                while( $row=mysqli_fetch_array($sec_query) ) {
                  
                  $json_upload_ltms = array('MODE' => $row['MODE'], 
                                      'QUEUE_ID' => '', 
                                      'INSPECTION_ID' => $row['INSPECTION_ID'], 
                                      'INSPECTOR_USERNAME' => $row['INSPECTOR_USERNAME'], 
                                      'STAGE_NO' => $row['STAGE_NO'], 
                                      'INSPECTION_REF_NO' => $row['INSPECTION_REF_NO'], 
                                      'TRANSACTION_NO' => $row['TRANSACTION_NO'], 
                                      'PURPOSE' => $row['PURPOSE'], 
                                      'PMVIC_CENTER' => $row['PMVIC_CENTER'], 
                                      'ITP_CODE' => 'Sys', 
                                      'VEHICLE_INFORMATION' => json_decode($row['VEHICLE_INFORMATION']), 
                                      'NOISE' => json_decode($row['NOISE']), 
                                      'EMISSIONS' => json_decode($row['EMISSIONS']), 
                                      'OPACITY' => json_decode($row['OPACITY']), 
                                      'LIGHTS' => json_decode($row['LIGHTS']), 
                                      'SPEEDOMETER' => json_decode($row['SPEEDOMETER']), 
                                      'SIDESLIP' => json_decode($row['SIDESLIP']), 
                                      'SUSPENSION' => json_decode($row['SUSPENSION']), 
                                      'BRAKES' => json_decode($row['BRAKES']),
                                      'DEFECTS' => json_decode($row['DEFECTS'])
                                    );
                    $response = sendToAPI($json_upload_ltms,$url_send_ltms);
                    $res = json_encode($response);
  
                    if($response["RESPONSE"]=="Success" || $response["RESPONSE"]=="SUCCESS"){
  
                      $sql_update="UPDATE tbl_dermalog SET status='OK', SUCCESS_LOG = 'SUCCESS', OVERALL_EVALUATION ='$res' WHERE TRANSACTION_NO='$TRANSACTION_NO' ";
                      $querys=mysqli_query($conn, $sql_update);
                      
                      if($querys){
                          $msg = "OK";
                          $status = 200;
                          $responseNew = $response["RESPONSE"];
                      }else{
                            $msg = "No Response";
                            $status = 204;
                      }
                      
                    }else{
                      $msg = "Not Modified";
                      $status = 304;
                    }
                }
  
              }else{
                $msg = "The SQL statement cannot be executed.";
                $status = -84;
                $responseNew = "DATA NOT INSERTED!!!";
                header("HTTP/1.0 404 No Data Available In LTMS");
              }
  
            }else{
                $Date_Tested = date('Y/m/d H:i:s');
                $insert_new_data = "INSERT INTO tbl_dermalog ( DATE_CREATED ,MODE, QUEUE_ID, PLATE_NUM, MV_FILE, CHASIS_NUM, ENGINE_NUM, INSPECTOR_USERNAME, STAGE_NO, INSPECTION_REF_NO, TRANSACTION_NO, PURPOSE,PMVIC_CENTER,ITP_CODE, VEHICLE_INFORMATION, NOISE, EMISSIONS, OPACITY, LIGHTS, SIDESLIP, SUSPENSION, BRAKES, SPEEDOMETER,DEFECTS,ERROR_LOG) 
                                  VALUES ('$Date_Tested','$MODE','$QUEUE_ID','$PLATE','$MV_FILE','$CHASSIS','$ENGINE','$INSPECTOR_USERNAME','$STAGE_NO','$INSPECTION_REF_NO','$TRANSACTION_NO','$PURPOSE','$PMVIC_CENTER','$ITP_CODE','$VEHICLE_INFORMATION','$NOISE','$EMISSIONS','$OPACITY','$LIGHTS','$SIDESLIP','$SUSPENSION','$BRAKES','$SPEEDOMETER','$DEFECTS','No Data found In LTMS') ";
              $validate_insert = "";
              $validate_insert = mysqli_query($conn,$insert_new_data);
              $msg = "No Data Found.";
              $status = 404;
              $responseNew = "PLEASE CHECK MV FILE NUMBER!!!";
              header("HTTP/1.0 404 No Data Available In LTMS");
            }

          }else{

            $msg = "Invalid Data";
            $status = 400;
            $responseNew = "PLEASE CHECK MV FILE NUMBER: ". $Clean_MV_FILE;
            header("HTTP/1.0 400 No Data Available In LTMS");

          }
           
        }else{
        
          $msg = "ERROR PLEASE CHECK!!!";
          $status = 422;
          $responseNew = "Duplicate Detected.";
          header("HTTP/1.0 422 Unprocessable Entity for Duplicate Records");
        }
     }
    }else{

      $msg = "Bad Request Check Request Body.";
      $status = 400;
      $responseNew = "NOT SAVING";
      header("HTTP/1.0 400 Bad Request");
    }

   $data = [
    'status' => $status,
    'message' => $msg,
    'response' => $responseNew
  ];
  echo json_encode($data);

  }else{

    $data = [
      'status' => 405,
      'message' => $requestMethod. ' Method Not Allowed',
    ];
    
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
    
  }

  function sendToAPI($json_data,$url){

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
