<?php
include ('../../backend/layout/inc/header.php');
if ($_SESSION['userdata']['access'] != 'Administrator') {
    echo "<script> window.location.href = '../../';</script>";
    die();
}
?>

<title>TODAY PMVIC UPLOAD'S</title>

<body>

    <?php include ('../../backend/layout/inc/right-sidebar.php'); ?>

    <?php include ('../../backend/layout/inc/left-side-bar.php'); ?>
<Style>
    .swal-wide{
    width:850px !important;
}
</Style>
 

    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div>

            <div class="min-height-200px">
                <div>
                    <!-- Simple Datatable start -->
                    <div class="card-box mb-30">
                        <div class="pd-20">
                            <div class="row">
                                <div class="col order-last">
                                    <!-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-pmvic"> <i class="bi bi-plus-circle"></i> ADD PMVIC</button> -->

                                </div>
                                <div class="col">
                                    <h4 class="text-center" data-color="#3033af">TODAY PMVIC DATA UPLOAD'S</h4>
                                </div>
                                <div class="col order-first">

                                </div>
                            </div>
                        </div>
                        <div class="pb-20" style="padding: 10px;">
                            <table class="data-table table hover multiple-select-row nowrap dataTable no-footer dtr-inline collapsed" id="upload_data">
                                <thead>
                                    <tr>
                                        <th>PMVIC</th>
                                        <th>MVISR</th>
                                        <th>MV FILE</th>
                                        <th>PLATE</th>
                                        <th>CHASSIS</th>
                                        <th>ENGINE</th>
                                        <th>STAGE</th>
                                        <th>INSPEC. NAME</th>
                                        <th>OVERALL RESULT</th>
                                        <th>DATE</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- Simple Datatable End -->
                </div>
            </div>

            <!-- ADD -->
            <div class="modal fade bs-example-modal-lg" id="re-upload" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myLargeModalLabel">
                                RE-UPLOAD DATA
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                ×
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="formReupload" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">ID</label>
                                            <input type="text" class="form-control" name="id-upload" id="id-upload" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">PMVIC</label>
                                            <input type="text" class="form-control" name="pmvic-upload" id="pmvic-upload" readonly>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">INSPECTION REF NO :</label>
                                            <input type="text" class="form-control" name="ref_no" id="ref_no" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">PLATE NUM:</label>
                                            <input type="text" class="form-control" name="plate-upload" id="plate-upload">
                                            <span class="error-plate"></span>

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">MV FILE NUM:</label>
                                            <input type="text" class="form-control" name="mvfile-upload" id="mvfile-upload">
                                            <span class="error-mvfile"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">EMISSION HC:</label>
                                        <input type="text" class="form-control" name="emission_hc" id="emission_hc">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="">EMISSION CO:</label>
                                        <input type="text" class="form-control" name="emission_co" id="emission_co">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="">OPACITY K:</label>
                                        <input type="text" class="form-control" name="opacity_k" id="opacity_k">
                                    </div>
                                </div>
                                <input type="hidden" id="pmvic_name" name="pmvic_name">
                                <input type="hidden" id="Engine" name="Engine">
                                <input type="hidden" id="Chassis" name="Chassis">
                                <input type="hidden" id="inspector_name" name="inspector_name">
                                <input type="hidden" id="id" name="id">
                                <input type="hidden" id="inspection_id" name="inspection_id">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="Submit" class="btn btn-primary" id="reupload-submit">
                                Update and Re-Upload
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ADD MODAL -->

            <!-- DELETE MODAL -->

            <div class="modal fade " id="upload-deleted" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="myLargeModalLabel">
                                DELETE PMVIC RECORDS
                            </h6>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                ×
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="formDeleted">
                                <div class="row">

                                    <input type="hidden" class="form-control" name="id-deleted" id="id-deleted">
                                    <input type="hidden" class="form-control" name="DATE-CREATED" id="DATE-CREATED">
                                    <div class="col-md-12 text-center">
                                        <div id="mv-file"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="Submit" class="btn btn-danger" id="MoveToDeleted">
                                DELETE
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <?php include ('../../backend/layout/inc/footer.php'); ?>

            <script>
                $(document).ready(function() {
                    


                    // const customTooltip = () => {
                    //     setTimeout(() => {
                    //         //let trList = document.querySelectorAll('tr');
                    //         let trList = document.querySelectorAll('.hovertooltip');

                    //         for (let i = 1; i < trList.length; i++) {
                    //             trList[i].addEventListener('mouseover', e => {
                    //                 if (i) {
                    //                     document.querySelector(`.container-tooltip_${i}`).classList.remove('hide-item');
                    //                 }
                    //             });
                    //         }

                    //         for (let i = 1; i < trList.length; i++) {
                    //             trList[i].addEventListener('mouseout', e => {
                    //                 document.querySelector(`.container-tooltip_${i}`).classList.add('hide-item');
                    //             });
                    //         }
                    //     }, 1000);
                    // }


                    let pmvic_data = $('#upload_data').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "scrollCollapse": true,
                        "autoWidth": false,
                        "responsive": true,
                        "order": [],
                        "ajax": {
                            url: "../../../private/controller/upload/process-today-upload.php",
                            type: "POST"
                        },
                        "columnDefs": [{
                            "targets": "datatable-nosort",
                            "orderable": false,
                        }, 
                        { className: "hovertooltip", "targets": [ 8 ] }
                            ],
                        lengthMenu: [
                            [10, 25, 50, -1],
                            [10, 25, 50, "All"]
                        ],
                        language: {
                            info: "_START_-_END_ of _TOTAL_ entries",
                            searchPlaceholder: "Search Here",
                            paginate: {
                                next: '<i class="ion-chevron-right"></i>',
                                previous: '<i class="ion-chevron-left"></i>'
                            }
                        },
                    });

                   

                    $(document).on('click', '.re-upload', function() {
                        event.preventDefault();

                        let reupload_id = $(this).data('id');

                        $.ajax({
                            method: "POST",
                            url: "../../../private/controller/upload/fetch-upload.php",
                            data: {
                                'reupload_id': reupload_id
                            },
                            success: function(response) {
                                const data = JSON.parse(response);
                                

                                //$('#opacity_k').val(JSON.parse(data.OPACITY).Result_K);
                                //$('#emission_co').val(JSON.parse(data.EMISSIONS).Result_CO);
                                //$('#emission_hc').val(JSON.parse(data.EMISSIONS).Result_HC);

                                $('#id-upload').val(data.id);

                                $('#pmvic-upload').val(data.PMVIC_CENTER);

                                $('#ref_no').val(data.INSPECTION_REF_NO);

                                $('#mvfile-upload').val(data.MV_FILE);

                                $('#plate-upload').val(data.PLATE_NUM);

                                $('#Engine').val(data.ENGINE_NUM);

                                $('#Chassis').val(data.CHASIS_NUM);

                                $('#inspector_name').val(data.INSPECTOR_USERNAME);

                                $('#id').val(data.id);

                                $('#pmvic_name').val(data.PMVIC_CENTER);

                                $('#inspection_id').val(data.INSPECTION_ID);

                                $('#re-upload').modal('show');
                            },
                            error: function(response) {
                                poUpRightCorner('error', 'Error Seleting Data');
                            }
                        });
                    });

                    $(document).on('click', '.fetch-deleted', function() {
                        event.preventDefault();

                        let reupload_id = $(this).data('id');

                        $.ajax({
                            method: "POST",
                            url: "../../../private/controller/upload/fetch-upload.php",
                            data: {
                                'reupload_id': reupload_id
                            },
                            success: function(response) {
                                const data = JSON.parse(response);

                                $('#id-deleted').val(data.id);
                                $('#mv-file').html("MV FILE No: <b>" + data.TRANSACTION_NO + "</b> Move to Deleted History!");

                                $('#upload-deleted').modal('show');
                            },
                            error: function(response) {
                                poUpRightCorner('error', 'Error Seleting Data');
                            }
                        });
                    });
                  
                  $(document).on('click', '.fetch-error', function() {
                        event.preventDefault();

                        let reupload_id = $(this).data('id');

                        $.ajax({
                            method: "POST",
                            url: "../../../private/controller/upload/fetch-upload.php",
                            data: {
                                'reupload_id': reupload_id
                            },
                            success: function(response) {
                                const data = JSON.parse(response);

                                swal.fire({
                                        html: `<div>
                                                ${(data.ERROR_LOG == null ? "<span style='color:green'>NO ERROR</span>" : "<span style='color:red'>" + data.ERROR_LOG + "</span>")}
                                                </div>`,
                                        title: "ERROR STATUS MVISR : " + data.INSPECTION_REF_NO ,
                                        customClass: 'swal-wide',
                                        showCancelButton: true,
                                        showConfirmButton:false
                                        })

                                
                                
                            },
                            error: function(response) {
                                poUpRightCorner('error', 'Error Seleting Data');
                            }
                        });
                    });

                    $(document).on('click', '.fetch-result', function() {
                        event.preventDefault();

                        let reupload_id = $(this).data('id');

                        $.ajax({
                            method: "POST",
                            url: "../../../private/controller/upload/fetch-upload.php",
                            data: {
                                'reupload_id': reupload_id
                            },
                            success: function(response) {
                                const data = JSON.parse(response);

                                if(isEmpty(data['OVERALL_EVALUATION'])){
                                    swal.fire({
                                            html: `<table class="data-table table hover multiple-select-row nowrap dataTable table-sm" border=1 ">
                                                    <thead>
                                                        <tr>
                                                            <th>RESPONSE</th>
                                                            <th>OVERALL_EVALUATION</th>
                                                            <th>EMISSION_TEST</th>
                                                            <th>OPACITY_TEST</th>
                                                            <th>LIGHT_TEST</th>
                                                            <th>SPEED_TEST</th>
                                                            <th>BRAKES_TEST</th>
                                                            <th>VISUAL_DEFECTS_FOUND</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr >
                                                            <td colspan="8"><p class='text-primary text-center fs-6'>NOT UPLOADED, NO TEST RESULT</p></td>
                                                        </tr>
                                            </tbody>
                                            </table>`,
                                            title: "OVERALL TEST RESULT MVISR : " + data.INSPECTION_REF_NO ,
                                            customClass: 'swal-wide',
                                            showCancelButton: true,
                                            showConfirmButton:false
                                    })
                                return;
                                }
                                
                                const OverAll = JSON.parse(data['OVERALL_EVALUATION']);
                                


                                let EMISSION_VERDICT = isUndefined(OverAll['LTO_EVALUATION'],['EMISSION_TEST']);
                                let OPACITY_VERDICT = isUndefined(OverAll['LTO_EVALUATION'],['OPACITY_TEST']);
                                let LIGHT_VERDICT = isUndefined(OverAll['LTO_EVALUATION'],['LIGHT_TEST']);
                                let SPEEDOMETER_VERDICT = isUndefined(OverAll['LTO_EVALUATION'],['SPEED_TEST']);
                                let BRAKES_VERDICT = isUndefined(OverAll['LTO_EVALUATION'],['BRAKES_TEST']);
                                let SUSPENSION_VERDICT = isUndefined(OverAll['LTO_EVALUATION'],['SUSPENSION_TEST']);
                                let SIDESLIP_VERDICT = isUndefined(OverAll['LTO_EVALUATION'],['SIDESLIP_TEST']);
                                let VISUAL_DEFECTS_FOUND = isUndefined(OverAll['PMVIC_TESTS'],['VISUAL_DEFECTS_FOUND']);

                                

                                
                                EMISSION_VERDICT = (EMISSION_VERDICT == 'No' ? OverAll['LTO_EVALUATION']['EMISSION_TEST']['EMISSION_VERDICT'] : "No Test Result");
                                OPACITY_VERDICT = (OPACITY_VERDICT == 'No' || OPACITY_VERDICT == null ? OverAll['LTO_EVALUATION']['OPACITY_TEST']['OPACITY_VERDICT'] : "No Test Result" );
                                LIGHT_VERDICT = (LIGHT_VERDICT == 'No' || LIGHT_VERDICT == null ? OverAll['LTO_EVALUATION']['LIGHT_TEST']['LIGHT_VERDICT'] : "No Test Result");
                                SPEEDOMETER_VERDICT = (SPEEDOMETER_VERDICT == 'No' || SPEEDOMETER_VERDICT == null ? OverAll['LTO_EVALUATION']['SPEED_TEST']['SPEEDOMETER_VERDICT'] : "No Test Result");
                                SUSPENSION_VERDICT = (SUSPENSION_VERDICT == 'No' || SUSPENSION_VERDICT == null ? OverAll['LTO_EVALUATION']['SUSPENSION_TEST']['SUSPENSION_VERDICT'] : "No Test Result");
                                SIDESLIP_VERDICT = (SIDESLIP_VERDICT == 'No' || SIDESLIP_VERDICT == null ? OverAll['LTO_EVALUATION']['SIDESLIP_TEST']['SIDESLIP_VERDICT'] : "No Test Result");
                                BRAKES_VERDICT = (BRAKES_VERDICT == 'No' || BRAKES_VERDICT == null ? OverAll['LTO_EVALUATION']['BRAKES_TEST']['BRAKES_VERDICT'] : "No Test Result");
                                VISUAL_DEFECTS_FOUND = (VISUAL_DEFECTS_FOUND == 'No' || VISUAL_DEFECTS_FOUND == null ? OverAll['PMVIC_TESTS']['VISUAL_DEFECTS_FOUND'] : "No Test Result");

                              
                                


                                swal.fire({
                                        html: `<table class="data-table table hover multiple-select-row nowrap dataTable table-sm" border=1 ">
                                                <thead>
                                                    <tr>
                                                        <th>RESPONSE</th>
                                                        <th>OVERALL_EVALUATION</th>
                                                        <th>EMISSION_TEST</th>
                                                        <th>OPACITY_TEST</th>
                                                        <th>LIGHT_TEST</th>
                                                        <th>SPEED_TEST</th>
                                                        <th>SIDESLIP_TEST</th>
                                                        <th>SUSPENSION_TEST</th>
                                                        <th>BRAKES_TEST</th>
                                                        <th>VISUAL_DEFECTS_FOUND</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><p class='text-success text-center .fs-6'>${OverAll['RESPONSE']}</p></td>
                                                        <td>${(OverAll['OVERALL_EVALUATION'] == -1) ? "<p class='text-danger text-center fs-6'>Failed</p>" : "<p class='text-success text-center fs-6'>Passed</p>"}</td>
                                                        <td>${(EMISSION_VERDICT == null || EMISSION_VERDICT == 'No Test Result' ? "<p class='text-center fs-6'>No Test Result</p>" : EMISSION_VERDICT == -1 ? "<p class='text-danger text-center fs-6'>Failed</p>" : "<p class='text-success text-center fs-6'>Passed</p>")}</td>
                                                        <td>${(OPACITY_VERDICT == null || OPACITY_VERDICT == 'No Test Result' ? "<p class='text-center fs-6'>No Test Result</p>" : OPACITY_VERDICT == -1 ? "<p class='text-danger text-center fs-6'>Failed</p>" : "<p class='text-success text-center fs-6'>Passed</p>")}</td>
                                                        <td>${(LIGHT_VERDICT == null || LIGHT_VERDICT == 'No Test Result' ? "<p class='text-center fs-6'>No Test Result</p>" : LIGHT_VERDICT == -1 ? "<p class='text-danger text-center fs-6'>Failed</p>" : "<p class='text-success text-center fs-6'>Passed</p>")}</td>
                                                        <td>${(SPEEDOMETER_VERDICT == null || SPEEDOMETER_VERDICT == 'No Test Result' ? "<p class='text-center fs-6'>No Test Result</p>" : SPEEDOMETER_VERDICT == -1 ? "<p class='text-danger text-center fs-6'>Failed</p>" : "<p class='text-success text-center fs-6'>Passed</p>")}</td>
                                                        <td>${(SIDESLIP_VERDICT == null || SIDESLIP_VERDICT == 'No Test Result' ? "<p class='text-center fs-6'>No Test Result</p>" : SIDESLIP_VERDICT == -1 ? "<p class='text-danger text-center fs-6'>Failed</p>" : "<p class='text-success text-center fs-6'>Passed</p>")}</td>
                                                        <td>${(SUSPENSION_VERDICT == null || SUSPENSION_VERDICT == 'No Test Result' ? "<p class='text-center fs-6'>No Test Result</p>" : SUSPENSION_VERDICT == -1 ? "<p class='text-danger text-center fs-6'>Failed</p>" : "<p class='text-success text-center fs-6'>Passed</p>")}</td>
                                                        <td>${(BRAKES_VERDICT == null || BRAKES_VERDICT == 'No Test Result' ? "<p class='text-center fs-6'>No Test Result</p>" : BRAKES_VERDICT == -1 ? "<p class='text-danger text-center fs-6'>Failed</p>" : "<p class='text-success text-center fs-6'>Passed</p>")}</td>
                                                        <td><p class='text-success text-center fs-6'>${(VISUAL_DEFECTS_FOUND == null || VISUAL_DEFECTS_FOUND == 'No Test Result' ? "<p class='text-center fs-6'>No Test Result</p>" : OverAll['PMVIC_TESTS']['VISUAL_DEFECTS_FOUND'])}</p></td>
                                                    </tr>
                                        </tbody>
                                        </table>`,
                                        title: "OVERALL TEST RESULT MVISR : " + data.INSPECTION_REF_NO ,
                                        customClass: 'swal-wide',
                                        showCancelButton: true,
                                        showConfirmButton:false
                                        })

                               
                                


                               function isUndefined(array, index) {
                                    return ((String(array[index]) == "undefined") ? "Yes" : "No");
                                }
                              

 
                            },
                            error: function(response) {
                                poUpRightCorner('error', 'Error Seleting Data');
                            }
                        });
                    });

                    function isEmpty(val){
                        return (val === undefined || val == null || val.length <= 0) ? true : false;
                    }

                    $(document).on('click', '#MoveToDeleted', function() {
                        event.preventDefault();

                        let form = $('#formDeleted')[0];
                        let data = new FormData(form);


                        $.ajax({
                            type: "POST",
                            url: "../../../private/controller/deleted/deleted-update.php",
                            data: data,
                            processData: false,
                            contentType: false,
                            cache: false,
                            async: false,
                            beforeSend: function() {
                                $('#MoveToDeleted').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                                $('#MoveToDeleted').attr("disabled", true);
                                $('#MoveToDeleted').css({
                                    "border-radius": "50%"
                                });
                            },

                            success: function(data) {

                                // console.log(data);

                                if (data == 'true') {
                                    poUpRightCorner('success', 'Delete Successfully.');
                                    pmvic_data.ajax.reload();
                                } else {
                                    poUpRightCorner('error', 'Someting Went Wrong!!!.');
                                }

                            },
                            complete: function() {

                                $('#upload-deleted').modal('hide');
                                //$('#formPmvicUpdate').trigger("reset");
                                $('#MoveToDeleted').html('Submit');
                                $('#MoveToDeleted').attr("disabled", false);
                                $('#MoveToDeleted').css({
                                    "border-radius": "4px"
                                });


                            },
                            error: function(data) {

                                poUpRightCorner('error', data.statusText);
                            }
                        });
                    });


                    $(document).on('click', '#reupload-submit', function() {
                        event.preventDefault();

                        //let update_id = $('#pmvicID').val();

                        let form = $('#formReupload')[0];
                        let data = new FormData(form);

                        checkUserInputs(data);

                        if (data.get('plate-upload') != '' && data.get('mvfile-upload') != '') {

                            $.ajax({
                                type: "POST",
                                url: "../../../private/controller/upload/update-upload.php",
                                data: data,
                                processData: false,
                                contentType: false,
                                cache: false,
                                async: false,
                                beforeSend: function() {
                                    $('#reupload-submit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                                    $('#reupload-submit').attr("disabled", true);
                                    $('#reupload-submit').css({
                                        "border-radius": "50%"
                                    });
                                },

                                success: function(data) {

                                    // console.log(data);


                                    if (data == 'true') {
                                        poUpRightCorner('success', 'Update Successfully.');
                                        pmvic_data.ajax.reload();
                                        $('#re-upload').modal('hide');
                                        
                                    } else {
                                        poUpRightCorner('error', 'Someting Went Wrong!!!.');
                                    }

                                },
                                complete: function() {

                                    $('#re-upload').modal('hide');
                                    $('#formReupload').trigger("reset");
                                    $('#reupload-submit').html('Submit');
                                    $('#reupload-submit').attr("disabled", false);
                                    $('#reupload-submit').css({
                                        "border-radius": "4px"
                                    });


                                },
                                error: function(data) {

                                    poUpRightCorner('error', data.statusText);
                                }
                            });

                        } else {
                            return false;
                        }
                    });

                    const showMSG = (data, domId, msg, domIdError) => {
                        if ($.trim(data.get(`${domId}`)).length == 0) {
                            $(`${domIdError}`).html(`<small class='ml-3'><span style='color:red;'> Please type ${msg}.</span></small>`);
                            setInterval(function() {
                                $(`${domIdError}`).html("");
                            }, 5000);
                        }
                    }

                    function checkUserInputs(data) {
                        showMSG(
                            data,
                            'plate-upload',
                            'Plate No.',
                            '.error-plate'
                        )

                        showMSG(
                            data,
                            'mvfile-upload',
                            'MV File No.',
                            '.error-mvfile'
                        )
                    }
                });

                function poUpRightCorner(status, message) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: status,
                        title: message
                    })
                }
            </script>