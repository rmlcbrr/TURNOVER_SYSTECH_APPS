<?php
    include '../../../initialize.php';

    $transact = new Transaction();

    if(isset($_POST['uploadCounts'])
    ) {
        $transact->countNumbersOfUploads(json_decode($_POST['uploadCounts']));
        die();
    }   

    if(isset($_POST['totalAmount'])
    ) {
        $transact->totalUploads(json_decode($_POST['totalAmount']));
        die();
    }   