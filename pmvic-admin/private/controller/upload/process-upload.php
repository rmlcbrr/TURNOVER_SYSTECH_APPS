<?php
include '../../initialize.php';
//session_start();
$upload = new Upload();
$result = $upload->getUpload();

$output = array();
$data = array();
$i=1;


foreach ($result['datafetch'] as $row) {
    $sub_array = array();

    $Action = '<td><div class="dropdown">
                        <a
                            class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                            href="#"
                            role="button"
                            data-toggle="dropdown"
                        >
                            <i class="dw dw-more"></i>
                        </a>
                        <div
                            class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list"
                        >
                            <a class="dropdown-item re-upload"  data-id="' . $row['id'] . '"
                                ><i class="dw dw-upload"></i> Re-upload</a
                            >

                            <a class="dropdown-item upload-deleted"  data-id="' . $row['id'] . '"
                            ><i class="dw dw-trash"></i> Delete</a >
                        </div>
                    </div></td>';

 
    $emissionRes = "";
    
    $emissionRes = $row['SUCCESS_LOG'] == 'SUCCESS' ? 
    '<span class="dtr-data"><span class="badge badge-pill" data-bgcolor="#e7ebf5" data-color="#265ed7" style="color: rgb(12 151 35); background-color: rgb(199 237 215);">'.$row['SUCCESS_LOG'].'</span></span>': 
    '<span class="dtr-data"><span class="badge badge-pill" data-bgcolor="#e7ebf5" data-color="#265ed7" style="color: rgb(180 11 11); background-color: rgb(237 209 199);">Not Uploaded</span></span>';

    
   // $overAllResult = json_decode($row['OVERALL_EVALUATION'], TRUE);

   // if($row['OVERALL_EVALUATION']==1 || $row['OVERALL_EVALUATION']==-1 || $row['OVERALL_EVALUATION']==0 || empty($row['OVERALL_EVALUATION'])
   // ) {
    //    $appendTooltip = $upload->dataOverallEvaluationEmpty($overAllResult, $i);
    //} else {
     //   $appendTooltip = $upload->dataOverallEvaluation($overAllResult, $i);
    //}
  
//$appendTooltip.$row['PMVIC_CENTER']

    $sub_array[] = $row['PMVIC_CENTER'];
    $sub_array[] = $row['TRANSACTION_NO'];
    $sub_array[] = $row['MV_FILE'];
    $sub_array[] = $row['PLATE_NUM'];
    $sub_array[] = $row['CHASIS_NUM'];
    $sub_array[] = $row['ENGINE_NUM'];
    $sub_array[] = $row['STAGE_NO'];
    $sub_array[] = $row['INSPECTOR_USERNAME'];
    $sub_array[] = $emissionRes;
    $sub_array[] = date('m/d/Y', strtotime($row['DATE_CREATED']));
    $sub_array[] = $Action;


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
