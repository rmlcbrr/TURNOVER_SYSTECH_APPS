<?php
    include '../../../initialize.php';

    $transact = new Transaction();

    echo json_encode([
        'message' => $transact->getLiveTransact(),
        'status'  => 200
    ]);