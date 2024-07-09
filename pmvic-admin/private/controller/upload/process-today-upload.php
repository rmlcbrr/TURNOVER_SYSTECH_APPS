<?php
    include '../../initialize.php';
    session_start();
    $upload = new Upload();
    $result = $upload->getTodayUpload();

    $output = array();
    $data = array();
    $i=1;
    
    foreach($result['datafetch'] as $row)
    {
        $sub_array = array();

        // $Action = '<td>
        // <div class="dropdown">
        //                 <a
        //                     class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
        //                     href="#"
        //                     role="button"
        //                     data-toggle="dropdown"
        //                 >
        //                     <i class="dw dw-more"></i>
        //                 </a>
        //                 <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list"
        //                 >
        //                     <a class="dropdown-item re-upload"  data-id="'.$row['id'].'"
        //                         ><i class="dw dw-upload"></i> Re-upload</a >

        //                         <a class="dropdown-item fetch-deleted"  data-id="'.$row['id'].'"
        //                         ><i class="dw dw-trash"></i> Delete</a >
        //                 </div>
                        
        //             </div>
        //         </td>';

            // $overAllResult = "";
            // $emissionRes = "";
            // //$overAllResult = json_decode($row['OVERALL_EVALUATION'], TRUE);

            //  $overAllResult = json_decode($row['OVERALL_EVALUATION'], TRUE);

            // if($row['OVERALL_EVALUATION']==1 || $row['OVERALL_EVALUATION']==-1 || $row['OVERALL_EVALUATION']==0 || empty($row['OVERALL_EVALUATION'])
            // ) {
            //     $appendTooltip = $upload->dataOverallEvaluationEmpty($overAllResult, $i);
            // } else {
            //     $appendTooltip = $upload->dataOverallEvaluation($overAllResult, $i);
            // }

            $Action = '<td>
                        <style>
                        a {
                            position: relative;
                            display: inline-block;
                          }
                          
                          a[title]:hover::after {
                            content: attr(title);
                            position: absolute;
                            top: -100%;
                            left: -150%;
                            text-alignment:center;
                            background-color:#281f78;
                            color:white;
                            padding:10px;
                            font-weight:200;
                            font-size:12px;
                            border-radius:5px;
                          }
                        </style>
            			<a class="fetch-error h4 text-warning p-1" data-id="'.$row['id'].'" title ="ERROR"><i class="bi bi-exclamation-triangle-fill"></i></a >
                        <a class="fetch-result h4 text-info p-1" data-id="'.$row['id'].'" title ="TEST RESULT"><i class="bi bi-info-circle"></i></a >
                        <a class="re-upload h4 text-success p-1"  data-id="'.$row['id'].'" title ="RE_UPLOAD"><i class="bi bi-cloud-upload"></i></a >
                        <a class="fetch-deleted h4 text-danger p-1"  data-id="'.$row['id'].'" title ="DELETE"><i class="dw dw-trash"></i></a >
                        
             
                      </td>';

            $emissionRes = "";
    
            $emissionRes = !empty($row['OVERALL_EVALUATION']) ? 
            '<span class="dtr-data"><span class="badge badge-pill" data-bgcolor="#e7ebf5" data-color="#265ed7" style="color: rgb(12 151 35); background-color: rgb(199 237 215);">Uploaded</span></span>': 
            '<span class="dtr-data"><span class="badge badge-pill" data-bgcolor="#e7ebf5" data-color="#265ed7" style="color: rgb(180 11 11); background-color: rgb(237 209 199);">Not Uploaded</span></span>';
         


            $sub_array[] = $row['PMVIC_CENTER'];
            $sub_array[] = $row['TRANSACTION_NO'];
            $sub_array[] = $row['MV_FILE'];
            $sub_array[] = $row['PLATE_NUM'];
            $sub_array[] = $row['CHASIS_NUM'];
            $sub_array[] = $row['ENGINE_NUM'];
            $sub_array[] = $row['STAGE_NO'];
            $sub_array[] = $row['INSPECTOR_USERNAME'];
            $sub_array[] = $emissionRes;
            $sub_array[] = date('m/d/Y g:i a', strtotime($row['DATE_CREATED']));
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