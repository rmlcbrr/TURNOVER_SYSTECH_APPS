<?php
include '../../../initialize.php';
session_start();
$upload = new Upload();
$result = $upload->userGetUploadstoday($_SESSION['userdata']['pmvicName']);

$output = array();
$data = array();
$i=1;


foreach ($result['datafetch'] as $row) {
    $sub_array = array();

    $emissionRes = $row['SUCCESS_LOG'] == 'SUCCESS' ? 
    '<span class="badge badge-pill" data-bgcolor="#e7ebf5" data-color="#265ed7" style="color: rgb(12 151 35); background-color: rgb(199 237 215);">'.$row['SUCCESS_LOG'].'</span>': 
    '<span class="badge badge-pill" data-bgcolor="#e7ebf5" data-color="#265ed7" style="color: rgb(180 11 11); background-color: rgb(237 209 199);">Not Uploaded</span>';


    $overAllResult = json_decode($row['OVERALL_EVALUATION'], TRUE);

    if($row['OVERALL_EVALUATION']==1 || $row['OVERALL_EVALUATION']==-1 || $row['OVERALL_EVALUATION']==0 || empty($row['OVERALL_EVALUATION'])
    ) {
        $appendTooltip = $upload->dataOverallEvaluationEmpty($overAllResult, $i);
    } else {
        $appendTooltip = $upload->dataOverallEvaluation($overAllResult, $i);
    }

    $sub_array[] = $appendTooltip.$i++;
    $sub_array[] = $row['TRANSACTION_NO'];
    $sub_array[] = $row['MV_FILE'];
    $sub_array[] = $row['PLATE_NUM'];
    $sub_array[] = $row['CHASIS_NUM'];
    $sub_array[] = $row['ENGINE_NUM'];
    $sub_array[] = $emissionRes;
    


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
