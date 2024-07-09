<?php
include '../../../initialize.php';
session_start();
$upload = new Upload();
$result = $upload->userGetUploads($_SESSION['userdata']['pmvicName']);

$output = array();
$data = array();
$i=1;


foreach ($result['datafetch'] as $row) {
    $sub_array = array();

    $getEmission = "";
    $emissionRes = "";
    $getEmission = json_decode($row['EMISSIONS'], TRUE);
    $emissionRes = isset($getEmission['Status']['Status']) ? $getEmission['Status']['Status'] : " ";

    // if($_SESSION['userdata']['access'] == "Administrator"){

    $overAllResult = json_decode($row['OVERALL_EVALUATION'], TRUE);

    if($row['OVERALL_EVALUATION']==1 || $row['OVERALL_EVALUATION']==-1 || $row['OVERALL_EVALUATION']==0 || empty($row['OVERALL_EVALUATION'])
    ) {
        $appendTooltip = $upload->dataOverallEvaluationEmpty($overAllResult, $i);
    } else {
        $appendTooltip = $upload->dataOverallEvaluation($overAllResult, $i);
    }

    $sub_array[] = $appendTooltip.$row['PMVIC_CENTER'];
    $sub_array[] = $row['TRANSACTION_NO'];
    $sub_array[] = $row['MV_FILE'];
    $sub_array[] = $row['PLATE_NUM'];
    $sub_array[] = $row['CHASIS_NUM'];
    $sub_array[] = $row['ENGINE_NUM'];
    $sub_array[] = $row['STAGE_NO'];
    $sub_array[] = $row['INSPECTOR_USERNAME'];
    $sub_array[] = ($row['SUCCESS_LOG'] == 'SUCCESS') ? "SUCCESS" : "Not Uploaded";
    $sub_array[] = ($emissionRes == 1) ? "PASSED" : "FAILED";
    $sub_array[] = date('m/d/Y', strtotime($row['DATE_CREATED']));


    $data[] = $sub_array;
    $i++;
}
$output = array(
    "draw"              =>   intval($_POST["draw"]),
    "recordsTotal"      =>   $result['recordsTotal'],
    "recordsFiltered"   =>   $result['recordsFiltered'],
    "data"              =>   $data
);
echo json_encode($output);
