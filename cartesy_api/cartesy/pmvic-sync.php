<?php
  error_reporting(E_ALL);
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
        $EMISSIONS=json_encode($pss_json['EMISSIONS']);
        $OPACITY=json_encode($pss_json['OPACITY']);
        $DATEGET=$pss_json['DATEGET'];
         
        
        $query = "SELECT * FROM tbl_dermalog WHERE TRANSACTION_NO = '$TRANSACTION_NO' AND MV_FILE='$MV_FILE'";
        $result = mysqli_query($conn,$query);
        if(mysqli_num_rows($result) != 0){
        	header("HTTP/1.0 200");
            echo json_encode([
                'status' => 422,
                'message' => 'Unprocessable Entity for Duplicate Records',
              'MVISR'=> $TRANSACTION_NO
            ]);
      		return;
        }
         
         $Date_Tested = date("Y-m-d H:i", strtotime($DATEGET));
		 $Clean_MV_FILE = str_replace(' ','',$MV_FILE);
         $json_send_to_getinfo = array('mv_file_no' =>  $Clean_MV_FILE);
         if(strlen($Clean_MV_FILE) != 15){
           $failed_data = "INSERT INTO tbl_dermalog ( DATE_CREATED ,MODE, QUEUE_ID, PLATE_NUM, MV_FILE, CHASIS_NUM, ENGINE_NUM, INSPECTOR_USERNAME, STAGE_NO, INSPECTION_REF_NO, TRANSACTION_NO, PURPOSE,PMVIC_CENTER,ITP_CODE, VEHICLE_INFORMATION, NOISE, EMISSIONS, OPACITY, LIGHTS, SIDESLIP, SUSPENSION, BRAKES, SPEEDOMETER,DEFECTS,ERROR_LOG) 
                               VALUES ('$Date_Tested','$MODE','$QUEUE_ID','$PLATE','$MV_FILE','$CHASSIS','$ENGINE','$INSPECTOR_USERNAME','$STAGE_NO','$INSPECTION_REF_NO','$TRANSACTION_NO','$PURPOSE','$PMVIC_CENTER','$ITP_CODE','$VEHICLE_INFORMATION','$NOISE','$EMISSIONS','$OPACITY','$LIGHTS','$SIDESLIP','$SUSPENSION','$BRAKES','$SPEEDOMETER','$DEFECTS','CHECK MV FILE NUMBER') ";
           $validated_insert = "";
           $validated_insert = mysqli_query($conn,$failed_data );
         	header("HTTP/1.0 200");
            echo json_encode([
                'status' => 400,
                'message' => 'SYSTECH BAD REQUEST',
              	'MVISR'=> $TRANSACTION_NO
            ]);
      		return;
         }
         
         
         
         $catch_data = "loss";//sendToAPI($json_send_to_getinfo,$url_get_info);
         
         if($catch_data == null){
           $insert_new_data = "INSERT INTO tbl_dermalog ( DATE_CREATED ,MODE, QUEUE_ID, PLATE_NUM, MV_FILE, CHASIS_NUM, ENGINE_NUM, INSPECTOR_USERNAME, STAGE_NO, INSPECTION_REF_NO, TRANSACTION_NO, PURPOSE,PMVIC_CENTER,ITP_CODE, VEHICLE_INFORMATION, NOISE, EMISSIONS, OPACITY, LIGHTS, SIDESLIP, SUSPENSION, BRAKES, SPEEDOMETER,DEFECTS,ERROR_LOG) 
                               VALUES ('$Date_Tested','$MODE','$QUEUE_ID','$PLATE','$MV_FILE','$CHASSIS','$ENGINE','$INSPECTOR_USERNAME','$STAGE_NO','$INSPECTION_REF_NO','$TRANSACTION_NO','$PURPOSE','$PMVIC_CENTER','$ITP_CODE','$VEHICLE_INFORMATION','$NOISE','$EMISSIONS','$OPACITY','$LIGHTS','$SIDESLIP','$SUSPENSION','$BRAKES','$SPEEDOMETER','$DEFECTS','LTMS BAD REQUEST') ";
           $validate_insert = "";
           $validate_insert = mysqli_query($conn,$insert_new_data);
         	header("HTTP/1.0 200");
            echo json_encode([
                'status' => 400,
                'message' => 'LTMS BAD REQUEST',
              	'MVISR'=> $TRANSACTION_NO
            ]);
      		return;
         }
         
         $Inspection_ID = "loss";
        
         
         $insert_new_data = "INSERT INTO tbl_dermalog ( DATE_CREATED ,MODE, QUEUE_ID, PLATE_NUM, MV_FILE, CHASIS_NUM, ENGINE_NUM, INSPECTION_ID, INSPECTOR_USERNAME, STAGE_NO, INSPECTION_REF_NO, TRANSACTION_NO, PURPOSE,PMVIC_CENTER,ITP_CODE, VEHICLE_INFORMATION, NOISE, EMISSIONS, OPACITY, LIGHTS, SIDESLIP, SUSPENSION, BRAKES, SPEEDOMETER,DEFECTS) 
                                  VALUES ('$Date_Tested','$MODE','$QUEUE_ID','$PLATE','$MV_FILE','$CHASSIS','$ENGINE','$Inspection_ID','$INSPECTOR_USERNAME','$STAGE_NO','$INSPECTION_REF_NO','$TRANSACTION_NO','$PURPOSE','$PMVIC_CENTER','$ITP_CODE','$VEHICLE_INFORMATION','$NOISE','$EMISSIONS','$OPACITY','$LIGHTS','$SIDESLIP','$SUSPENSION','$BRAKES','$SPEEDOMETER','$DEFECTS') ";
        
         $validate_insert = "";
         
         $validate_insert = mysqli_query($conn,$insert_new_data);
         
         if($validate_insert){
         	$select_sql = "SELECT * FROM tbl_dermalog WHERE TRANSACTION_NO='$TRANSACTION_NO' order by id desc limit 1";
            $sec_query = mysqli_query($conn, $select_sql);
           	while( $row=mysqli_fetch_array($sec_query) ) {
              //$row['INSPECTION_ID']
              	$json_upload_ltms = array('MODE' => $row['MODE'], 
                                      'QUEUE_ID' => '', 
                                      'INSPECTION_ID' => "", 
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
              
              
              //$response = sendToAPI($json_upload_ltms,$url_send_ltms);
              //$decodeData = json_decode($responseApi);
              //$res = json_encode($response);
             
             
              
              
                           
              
  
                  $sql_update="UPDATE tbl_dermalog SET status='OK', SUCCESS_LOG = 'SUCCESS' WHERE TRANSACTION_NO='$TRANSACTION_NO' ";
                  $querys=mysqli_query($conn, $sql_update);  
                  header("HTTP/1.0 200");
                    echo json_encode([
                        'status' => 200,
                        'message' => 'UPLOADED',
                      	'MVISR'=> $TRANSACTION_NO
                    ]);
                    return;
               
            }
         }else{
           header("HTTP/1.0 200");
              echo json_encode([
                  'status' => 500,
                  'message' => 'DATABASE ERROR',
                'MVISR'=> $TRANSACTION_NO
              ]);
              return;
         }
         
         
         header("HTTP/1.0 200");
            echo json_encode([
                'status' => 200,
                'message' => 'GOOD'
            ]);
      		return;
         
       }
    }else{
    	header("HTTP/1.0 200");
        echo json_encode([
            'status' => 204,
            'message' => 'NO CONTENT'
        ], JSON_PRETTY_PRINT);
      return;
    }
    
  }else{
  	header("HTTP/1.0 200");
  	echo json_encode([
    	'status' => 405,
      	'message' => $requestMethod. ' Method Not Allowed'
    ], JSON_PRETTY_PRINT);
    return;
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