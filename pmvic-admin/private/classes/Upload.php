<?php

class Upload{

    public $id;
    public $CHASIS_NUM;
    public $DATE_CREATED;
    public $ENGINE_NUM;
    public $BRANCH_ID;
    public $PMVIC_CENTER;
    public $ITP_CODE;
    public $INSPECTION_ID;
    public $INSPECTION_REF_NO;
    public $INSPECTOR_USERNAME;
    public $MODE;
    public $MV_FILE;
    public $PLATE_NUM;
    public $PURPOSE;
    public $QUEUE_ID;
    public $STAGE_NO;
    public $TRANSACTION_NO; 
    public $VEHICLE_INFORMATION;
    public $BRAKES;
    public $DEFECTS;
    public $EMISSIONS; 
    public $LIGHTS;
    public $NOISE;
    public $OPACITY;
    public $SIDESLIP;
    public $SPEEDOMETER;
    public $SUSPENSION;
    public $ERROR_LOG;
    public $SUCCESS_LOG;
    public $STATUS;
    public $OVERALL_EVALUATION;



    public function __construct(){
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // admin upload record end

    public function getUpload(){

        $query = '';
        
        $query .= "SELECT * FROM tbl_dermalog ";
        if(isset($_POST["search"]["value"]))
        {
            $query .= 'WHERE 1 and (id LIKE "%'.$_POST["search"]["value"].'%" ';
            $query .= 'OR CHASIS_NUM LIKE "%'.$_POST["search"]["value"].'%" ';
            $query .= 'OR ENGINE_NUM LIKE "%'.$_POST["search"]["value"].'%" ';
            $query .= 'OR PMVIC_CENTER LIKE "%'.$_POST["search"]["value"].'%" ';
            $query .= 'OR INSPECTION_REF_NO LIKE "%'.$_POST["search"]["value"].'%" ';
            $query .= 'OR MV_FILE LIKE "%'.$_POST["search"]["value"].'%" ';
            $query .= 'OR PLATE_NUM LIKE "%'.$_POST["search"]["value"].'%" ';
            $query .= 'OR TRANSACTION_NO LIKE "%'.$_POST["search"]["value"].'%") ';
        } 

            $query .= 'and (isDeleted = 0) and YEAR(DATE_CREATED)="2024"';
        
        if(isset($_POST["order"]))
        {
            $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
        }
        else
        {
            $query .= 'ORDER BY id DESC ';
        }
        
        
        if($_POST["length"] != -1)
        {
            $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
        } 


        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $resultUpload = $stmt->fetchAll();

        $rowCount = $stmt->rowCount();
     //$this->RecordsTotal()
        return [
            'datafetch'       => $resultUpload,
            'recordsFiltered' => $rowCount,
            'recordsTotal'    =>$this->RecordsTotal()
        ];
    }

    
    function RecordsTotal()
    {
        $query = "SELECT COUNT(*) FROM tbl_dermalog WHERE isDeleted = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    

    public function getTodayUpload(){

        $query = '';
        
        $query .= "SELECT * FROM tbl_dermalog ";
        if(isset($_POST["search"]["value"]))
        {
            $query .= 'WHERE 1 and (id LIKE "%'.$_POST["search"]["value"].'%" ';
            $query .= 'OR CHASIS_NUM LIKE "%'.$_POST["search"]["value"].'%" ';
            $query .= 'OR ENGINE_NUM LIKE "%'.$_POST["search"]["value"].'%" ';
            $query .= 'OR PMVIC_CENTER LIKE "%'.$_POST["search"]["value"].'%" ';
            $query .= 'OR INSPECTION_REF_NO LIKE "%'.$_POST["search"]["value"].'%" ';
            $query .= 'OR MV_FILE LIKE "%'.$_POST["search"]["value"].'%" ';
            $query .= 'OR PLATE_NUM LIKE "%'.$_POST["search"]["value"].'%" ';
            $query .= 'OR TRANSACTION_NO LIKE "%'.$_POST["search"]["value"].'%") ';
        } 

         
          	$query .= 'and (DATE(DATE_CREATED) = DATE(CURDATE())) ';
            $query .= 'and (isDeleted = 0)';
       
        if(isset($_POST["order"]))
        {
            $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
        }
        else
        {
            $query .= 'ORDER BY id DESC ';
        }
        
        
        if($_POST["length"] != -1)
        {
            $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
        } 


        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $resultUpload = $stmt->fetchAll();

        $rowCount = $stmt->rowCount();

        return [
            'datafetch'   => $resultUpload,
            'recordsFiltered'    => $rowCount,
            'recordsTotal'=> $this->TodayRecordsTotal()
        ];
    }

    function TodayRecordsTotal()
    {
        $query = "SELECT COUNT(*) FROM tbl_dermalog WHERE DATE(DATE_CREATED) = DATE(CURDATE()) AND isDeleted = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // admin upload record end

    function dataOverallEvaluationEmpty($overAllResult, $index) {
        // settings tooltip datable
        $response   = '<span class="text-danger">No Data</span>';
        $all_eval  = '<span class="text-danger">No Data</span>';

        $noise    = '<span class="text-danger">No Data</span>';

        $emission  = '<span class="text-danger">No Data</span>';

        $opacity   = '<span class="text-danger">No Data</span>';

        $light   = '<span class="text-danger">No Data</span>';

        $sideslip  = '<span class="text-danger">No Data</span>';

        $speed    = '<span class="text-danger">No Data</span>';

        $suspension = '<span class="text-danger">No Data</span>';

        $brakes = '<span class="text-danger">No Data</span>';

        $vdf    = '<span class="text-danger">No Data</span>';

        //append element
        $tooltip = "
            <style>
                .cs-tooltip {
                    position: absolute;
                    top: 25px;
                    z-index: 99999999;
                    border-radius: 6px;
                    padding: 11px;
                    width: 153vh;
                    background: rgb(48, 51, 175);
                }
                .cs-tooltip :where(*) {
                    color:#fff;
                }
                .hide-item {
                    display: none;
                }
                .show-item {
                    display: block;
                }
                tr {
                    cursor: pointer;
                }
                .cs-tooltip .col-md-4 {
                    padding: 5px;
                }
                .cs-tooltip .row {
                    border-bottom: solid 1px #fff;
                }
                .tooltip-header {
                    display: flex;
                    font-weight: 800;
                    gap: 7px;
                    width: 265px;
                }
                .tooltip-body {
                    display: flex;
                    width: 265px;
                    gap: 7px;
                }
                .tooltip-body .col-md-4 {
                    background: #fff;
                    color: #000;
                    font-weight: 700;
                }
                i.icon-copy {
                    font-size: 15px;
                }
                @media(max-width: 768px) 
                {
                    .tooltip-header {
                        flex-direction: column;
                    }
                    
                    .tooltip-body {
                        flex-direction: column;
                    }
                    
                    .cs-tooltip.container-tooltip_1.p-3.hide-item {
                        display: flex;
                        width: 44vh !important;
                    }
                    .tooltip-header {
                        width: auto !important;
                    }
                    .tooltip-body {
                        width: 100px !important;
                    }
                }
            </style>
            <div class='cs-tooltip container-tooltip_$index hide-item p-3'>

                <div class='tooltip-header'>
                    <div class='col-md-4'>RESPONSE</div>
                    <div class='col-md-4'>OVERALL</div>

                    <div class='col-md-4'>NOISE</div>
                    <div class='col-md-4'>EMISSION</div>
                    <div class='col-md-4'>OPACITY</div>

                    <div class='col-md-4'>LIGHT</div>
                    <div class='col-md-4'>SIDESLIP</div>
                    <div class='col-md-4'>SPEED</div>

                    <div class='col-md-4'>SUSPENSION</div>
                    <div class='col-md-4'>BRAKES</div>
                    <div class='col-md-4'>VISUAL DEFECTS</div>
                </div>
                <div class='tooltip-body'>

                    <div class='col-md-4 text-success'>".$response."</div>
                    <div class='col-md-4'>".$all_eval."</div>

                    <div class='col-md-4'>".$noise."</div>
                    <div class='col-md-4'>".$emission."</div>
                    <div class='col-md-4'>". $opacity."</div>

                    <div class='col-md-4'>".$light."</div>
                    <div class='col-md-4'>".$sideslip."</div>
                    <div class='col-md-4'>".$speed."</div>

                    <div class='col-md-4'>".$suspension."</div>
                    <div class='col-md-4'>".$brakes."</div>
                    <div class='col-md-4'>".$vdf."</div>
                </div>
            </div>
        ";

        return $tooltip;
    }


    function dataOverallEvaluation($overAllResult, $index) {
        // settings tooltip datable
        $response  = $overAllResult['RESPONSE'];
        $all_eval = $overAllResult['OVERALL_EVALUATION']== 0 
        ? '<span class="text-danger">Failed</span>' 
        :"<span class='text-success'>Passed</span>";

        $noise    = $overAllResult['PMVIC_TESTS']['NOISE_TEST']== 0 
        ? "<i class='icon-copy ion-close-round text-danger'></i>" 
        :"<i class='icon-copy ion-checkmark-round text-success'></i>";

        $emission = $overAllResult['PMVIC_TESTS']['EMISSION_TEST']== 0 
        ? "<i class='icon-copy ion-close-round text-danger'></i>" 
        :"<i class='icon-copy ion-checkmark-round text-success'></i>";

        $opacity  = $overAllResult['PMVIC_TESTS']['OPACITY_TEST']== 0 
        ? "<i class='icon-copy ion-close-round text-danger'></i>" 
        :"<i class='icon-copy ion-checkmark-round text-success'></i>";

        $light    = $overAllResult['PMVIC_TESTS']['LIGHT_TEST']== 0 
        ? "<i class='icon-copy ion-close-round text-danger'></i>" 
        :"<i class='icon-copy ion-checkmark-round text-success'></i>";

        $sideslip = $overAllResult['PMVIC_TESTS']['SIDESLIP_TEST']== 0 
        ? "<i class='icon-copy ion-close-round text-danger'></i>" 
        :"<i class='icon-copy ion-checkmark-round text-success'></i>";

        $speed    = $overAllResult['PMVIC_TESTS']['SPEED_TEST']== 0 
        ? "<i class='icon-copy ion-close-round text-danger'></i>" 
        :"<i class='icon-copy ion-checkmark-round text-success'></i>";

        $suspension = $overAllResult['PMVIC_TESTS']['SUSPENSION_TEST'] == 0 
        ? "<i class='icon-copy ion-close-round text-danger'></i>" 
        :"<i class='icon-copy ion-checkmark-round text-success'></i>";

        $brakes = $overAllResult['PMVIC_TESTS']['BRAKES_TEST']== 0 
        ? "<i class='icon-copy ion-close-round text-danger'></i>" 
        :"<i class='icon-copy ion-checkmark-round text-success'></i>";

        $vdf    = $overAllResult['PMVIC_TESTS']['VISUAL_DEFECTS_FOUND']== 0 
        ? "<span class='text-success'>Passed</span>" 
        :"<span text-danger'>".$overAllResult['PMVIC_TESTS']['VISUAL_DEFECTS_FOUND']."</span>";

        //append element
        $tooltip = "
            <style>
                .cs-tooltip {
                    position: absolute;
                    top: 25px;
                    z-index: 99999999;
                    border-radius: 6px;
                    padding: 11px;
                    width: 153vh;
                    background: rgb(48, 51, 175);
                }
                .cs-tooltip :where(*) {
                    color:#fff;
                }
                .hide-item {
                    display: none;
                }
                .show-item {
                    display: block;
                }
                tr {
                    cursor: pointer;
                }
                .cs-tooltip .col-md-4 {
                    padding: 5px;
                }
                .cs-tooltip .row {
                    border-bottom: solid 1px #fff;
                }
                .tooltip-header {
                    display: flex;
                    font-weight: 800;
                    gap: 7px;
                    width: 265px;
                }
                .tooltip-body {
                    display: flex;
                    width: 265px;
                    gap: 7px;
                }
                .tooltip-body .col-md-4 {
                    background: #fff;
                    color: #000;
                    font-weight: 700;
                }
                i.icon-copy {
                    font-size: 15px;
                }
                @media(max-width: 768px) 
                {
                    .tooltip-header {
                        flex-direction: column;
                    }
                    
                    .tooltip-body {
                        flex-direction: column;
                    }
                    
                    .cs-tooltip.container-tooltip_1.p-3.hide-item {
                        display: flex;
                        width: 44vh !important;
                    }
                    .tooltip-header {
                        width: auto !important;
                    }
                    .tooltip-body {
                        width: 100px !important;
                    }
                }
            </style>
            <div class='cs-tooltip container-tooltip_$index hide-item p-3'>

                <div class='tooltip-header'>
                    <div class='col-md-4'>RESPONSE</div>
                    <div class='col-md-4'>OVERALL</div>

                    <div class='col-md-4'>NOISE</div>
                    <div class='col-md-4'>EMISSION</div>
                    <div class='col-md-4'>OPACITY</div>

                    <div class='col-md-4'>LIGHT</div>
                    <div class='col-md-4'>SIDESLIP</div>
                    <div class='col-md-4'>SPEED</div>

                    <div class='col-md-4'>SUSPENSION</div>
                    <div class='col-md-4'>BRAKES</div>
                    <div class='col-md-4'>VISUAL DEFECTS</div>
                </div>
                <div class='tooltip-body'>

                    <div class='col-md-4 text-success'>".$response."</div>
                    <div class='col-md-4'>".$all_eval."</div>

                    <div class='col-md-4'>".$noise."</div>
                    <div class='col-md-4'>".$emission."</div>
                    <div class='col-md-4'>". $opacity."</div>

                    <div class='col-md-4'>".$light."</div>
                    <div class='col-md-4'>".$sideslip."</div>
                    <div class='col-md-4'>".$speed."</div>

                    <div class='col-md-4'>".$suspension."</div>
                    <div class='col-md-4'>".$brakes."</div>
                    <div class='col-md-4'>".$vdf."</div>
                </div>
            </div>
        ";

        return $tooltip;
    }


    public function UpdateReUpload()
    {
        $data = [
            'PLATE_NUM'          => $this->PLATE_NUM,
            'MV_FILE'            => $this->MV_FILE,
            'OVERALL_EVALUATION' => $this->OVERALL_EVALUATION,
            'INSPECTION_REF_NO'  => $this->INSPECTION_REF_NO,
            'SUCCESS_LOG'        => $this->SUCCESS_LOG,
            'STATUS'             => 'OK',
            'id'                 => $this->id
        ];

        $query = "UPDATE tbl_dermalog SET 
        PLATE_NUM=:PLATE_NUM, 
        MV_FILE=:MV_FILE, 
        OVERALL_EVALUATION=:OVERALL_EVALUATION, 
        INSPECTION_REF_NO=:INSPECTION_REF_NO, 
        SUCCESS_LOG=:SUCCESS_LOG, STATUS=:STATUS WHERE id=:id";

        $stmt = $this->conn->prepare($query);
        $result = $stmt->execute($data);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    function get_total_all_upload_records()
    {
        $query = "SELECT COUNT(*) FROM tbl_dermalog";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    function fetchUpload($id){
        $query = "SELECT * FROM tbl_dermalog WHERE  id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        $upload = $stmt->fetch();
            
        return $upload;
    }

    // user dashboard start
    function All_Upload_Today($pmvic_Name){
        $query = "SELECT COUNT(*)
        FROM tbl_dermalog
        WHERE PMVIC_CENTER = '$pmvic_Name' AND isDeleted = 0 ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    function Upload_Today($pmvic_Name){
        $query = "SELECT COUNT(*)
        FROM tbl_dermalog
        WHERE DATE(DATE_CREATED) = DATE(CURDATE()) AND PMVIC_CENTER = '$pmvic_Name' AND isDeleted = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // user dashboard end

    public function UpdateToDeleted()
    {
        $user = new Login();
        $result = $user->get_userdata();

        $data = [
            
            'id'          => $this->id,
            'isDeleted'   => 1,
            'deleted_by'  => $result['username']
        ];

        $query = "UPDATE tbl_dermalog SET 
        isDeleted=:isDeleted, deleted_by=:deleted_by WHERE id=:id";

        $stmt = $this->conn->prepare($query);
        $result = $stmt->execute($data);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function UpdateToReplace()
    {
        $data = [
            'id'                 => $this->id,
            'isDeleted'   => 0
        ];

        $query = "UPDATE tbl_dermalog SET 
        isDeleted=:isDeleted WHERE id=:id";

        $stmt = $this->conn->prepare($query);
        $result = $stmt->execute($data);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // for user side
    public function userGetUploads($pmvicName){

        $query = '';
        
        $query .= "SELECT * FROM tbl_dermalog ";
        if(isset($_POST["search"]["value"]))
        {
            $query .= 'WHERE 1 and (id LIKE "%'.$_POST["search"]["value"].'%" ';
            $query .= 'OR CHASIS_NUM LIKE "%'.$_POST["search"]["value"].'%" ';
            $query .= 'OR ENGINE_NUM LIKE "%'.$_POST["search"]["value"].'%" ';
            $query .= 'OR PMVIC_CENTER LIKE "%'.$_POST["search"]["value"].'%" ';
            $query .= 'OR INSPECTION_REF_NO LIKE "%'.$_POST["search"]["value"].'%" ';
            $query .= 'OR MV_FILE LIKE "%'.$_POST["search"]["value"].'%" ';
            $query .= 'OR PLATE_NUM LIKE "%'.$_POST["search"]["value"].'%" ';
            $query .= 'OR TRANSACTION_NO LIKE "%'.$_POST["search"]["value"].'%") ';
        } 

            $query .= 'and isDeleted = 0 ';

            $query .= 'and (PMVIC_CENTER="'.$pmvicName.'") ';
        
        if(isset($_POST["order"]))
        {
            $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
        }
        else
        {
            $query .= 'ORDER BY DATE(DATE_CREATED) DESC,  TRANSACTION_NO DESC ';
        }
        
        
        if($_POST["length"] != -1)
        {
            $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
        } 


        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $resultUpload = $stmt->fetchAll();

        $rowCount = $stmt->rowCount();

        return [
            'datafetch'   => $resultUpload,
            'recordsFiltered'    => $rowCount,
            'recordsTotal'=> $this->allUserRecords($pmvicName)
        ];
    }

    function allUserRecords($pmvicName)
    {
        $query = "SELECT COUNT(*) FROM tbl_dermalog WHERE isDeleted = 0 and PMVIC_CENTER='$pmvicName'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

 

        // for user side
        public function userGetUploadstoday($pmvicName){

            $query = '';
            
            $query .= "SELECT * FROM tbl_dermalog ";
            if(isset($_POST["search"]["value"]))
            {
                $query .= 'WHERE 1 and (id LIKE "%'.$_POST["search"]["value"].'%" ';
                $query .= 'OR CHASIS_NUM LIKE "%'.$_POST["search"]["value"].'%" ';
                $query .= 'OR ENGINE_NUM LIKE "%'.$_POST["search"]["value"].'%" ';
                $query .= 'OR PMVIC_CENTER LIKE "%'.$_POST["search"]["value"].'%" ';
                $query .= 'OR INSPECTION_REF_NO LIKE "%'.$_POST["search"]["value"].'%" ';
                $query .= 'OR MV_FILE LIKE "%'.$_POST["search"]["value"].'%" ';
                $query .= 'OR PLATE_NUM LIKE "%'.$_POST["search"]["value"].'%" ';
                $query .= 'OR TRANSACTION_NO LIKE "%'.$_POST["search"]["value"].'%") ';
            } 
    
                $query .= 'and (isDeleted = 0) ';
    
                $query .= 'and (DATE(DATE_CREATED) = DATE(CURDATE())) ';
    
                $query .= 'and (PMVIC_CENTER="'.$pmvicName.'") ';
            
            if(isset($_POST["order"]))
            {
                $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
            }
            else
            {
                $query .= 'ORDER BY id DESC ';
            }
            
            
            if($_POST["length"] != -1)
            {
                $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
            } 
    
    
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $resultUpload = $stmt->fetchAll();
    
            $rowCount = $stmt->rowCount();
    
            return [
                'datafetch'   => $resultUpload,
                'recordsFiltered'    => $rowCount,
                'recordsTotal'=> $this->RecordsTotalUser($pmvicName)
            ];
        }

        function RecordsTotalUser($pmvicName)
        {
            $query = "SELECT COUNT(*) FROM tbl_dermalog WHERE isDeleted = 0 and PMVIC_CENTER='$pmvicName' AND DATE(DATE_CREATED) = DATE(CURDATE())";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
    
            return $stmt->fetchColumn();
        }
    
        function RecordsTotalUsertoday($pmvicName)
        {
            $query = "SELECT COUNT(*) FROM tbl_dermalog WHERE isDeleted = 0 and PMVIC_CENTER='$pmvicName' AND DATE(DATE_CREATED) = DATE(CURDATE())";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
    
            return $stmt->fetchColumn();
        }

}