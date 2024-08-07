<?php
include '../../initialize.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (!empty($_FILES['pmvicProfile']['name'])) {
        $ImageTmp = file_get_contents($_FILES['pmvicProfile']['tmp_name']);
        $database64 = base64_encode($ImageTmp);
    } else {
        $database64 = "";
    }

    $tbl_pmvic = new Center();
    $tbl_pmvic->pmvic_name        = htmlspecialchars(trim($_POST["pmvicName"]));
    $tbl_pmvic->pmvic_description = htmlspecialchars(trim($_POST["pmvicDesc"]));
    $tbl_pmvic->pnvic_address     = htmlspecialchars(trim($_POST["pmvicAddress"]));
    $tbl_pmvic->pmvic_ownner      = htmlspecialchars(trim($_POST["pmvicOwner"]));
    $tbl_pmvic->pmvic_contact     = htmlspecialchars(trim($_POST["pmvicContact"]));
    $tbl_pmvic->pmvic_status      = htmlspecialchars(trim($_POST["pmvicStatus"]));
    $tbl_pmvic->pmciv_price       = htmlspecialchars(trim($_POST["pmvicPrice"]));
    $tbl_pmvic->pmciv_profile = $database64;
    $tbl_pmvic->date_operate  = htmlspecialchars(trim($_POST["pmvicDateOperate"]));

    $result = $tbl_pmvic->InsertCenter();

    echo json_encode($result);
}
