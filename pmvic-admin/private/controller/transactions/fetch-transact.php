<?php
    include '../../initialize.php';

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        
        $tbl_transact = new Transaction();
        $get_user_id = $tbl_transact->fetchTransact($_POST['edit_id']);
        
        echo json_encode($get_user_id );
    }