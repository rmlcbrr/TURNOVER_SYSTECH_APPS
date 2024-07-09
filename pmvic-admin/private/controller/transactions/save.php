<?php
    include '../../initialize.php';

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        
        $tbl_transact = new Transaction();

        $populateData = [
            'vehicleTpye'    => json_encode($_POST['vehicleTpye']),
            'stageType'      => json_encode($_POST['stageType']),
            'amounPerUpload' => json_encode($_POST['amounPerUpload'])
        ];

        $tbl_transact->pmvic_name     = htmlspecialchars(trim($_POST["pmvic_id"]));
        $tbl_transact->transact_data  = json_encode($populateData);
        
        $result = $tbl_transact->save();
    }