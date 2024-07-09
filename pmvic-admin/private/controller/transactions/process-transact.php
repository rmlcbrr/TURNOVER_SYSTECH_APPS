<?php
include '../../initialize.php';

$transact = new Transaction();
$result = $transact->getTransact();

$output = array();
$data = array();
$filtered_rows = count($result);
$i = 1;
$count = 0;

foreach ($result as $row) {
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
                            <a class="dropdown-item fetch-transact"  data-id="' . $row['transact_id'] . '"
                                ><i class="dw dw-edit2"></i> Edit</a
                            >
                            <a class="dropdown-item select-delete-transact" data-id="' . $row['transact_id'] . '"
                                ><i class="dw dw-delete-3"></i> Delete</a
                            > 
                        </div>
                    </div></td>';



    foreach (json_decode(json_decode($row['transact_data'])->vehicleTpye) as $vtype) {
        $vehicleType[] = $vtype.'<br>';
    }
    foreach (json_decode(json_decode($row['transact_data'])->amounPerUpload) as $amoutU) {
        $amountUpload[] = $amoutU.'<br>';
    }

    $sub_array[] = ++$count;
    $sub_array[] = $row['pmvic_name'];
    $sub_array[] = $vehicleType;
    $sub_array[] = $amountUpload;
    $sub_array[] = $Action;

    $data[] = $sub_array;
    $i++;
}
$output = array(
    "draw"              =>   intval($_POST["draw"]),
    "recordsTotal"      =>   $filtered_rows,
    "recordsFiltered"   =>   $transact->get_total_all_transact_records(),
    "data"              =>   $data
);
echo json_encode($output);