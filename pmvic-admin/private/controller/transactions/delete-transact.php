<?php
    include '../../initialize.php';

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        
        $tbl_transact = new Transaction();
        $tbl_transact->transact_id= htmlspecialchars(trim($_POST["delete_id"]));

        $result = $tbl_transact->DeleteTransact();

        echo json_encode($result);
    }