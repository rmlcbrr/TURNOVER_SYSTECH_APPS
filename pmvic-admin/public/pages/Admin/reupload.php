<?php include('../../backend/layout/inc/header.php');
if ($_SESSION['userdata']['access'] != 'Administrator') {
    echo "<script> window.location.href = '../../';</script>";
    die();
}
?>

<title>ALL PMVIC DATA</title>


<body>

    <?php include('../../backend/layout/inc/right-sidebar.php'); ?>

    <?php include('../../backend/layout/inc/left-side-bar.php'); ?>

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
                                    <h4 class="text-center" data-color="#3033af">ALL PMVIC DATA UPLOAD'S</h4>
                                </div>
                                <div class="col order-first">

                                </div>
                            </div>
                        </div>
                        <div class="pb-20" style="padding: 10px;">
                            <table class="data-table table hover multiple-select-row nowrap dataTable no-footer dtr-inline collapsed" id="upload_datas">
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
                                        <th>SUCCESS LOG</th>
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

            <div class="modal fade " id="DeleteReupload" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="myLargeModalLabel">
                                DELETE RE-UPLOAD RECORDS
                            </h6>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                ×
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="formDeleted">
                                <div class="row">
                                    <input type="hidden" class="form-control" name="id-deleted" id="id-deleted">
                                    <div class="col-md-12 text-center">
                                        <div id="label-delete"></div>
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

            <?php include('../../backend/layout/inc/footer.php'); ?>

            <script>
                $(document).ready(function() {

                    const customTooltip = () => {
                        setTimeout(() => {
                            //let trList = document.querySelectorAll('tr');
                            let trList = document.querySelectorAll('.hovertooltip');

                            for (let i = 1; i < trList.length; i++) {
                                trList[i].addEventListener('mouseover', e => {
                                    if (i) {
                                        document.querySelector(`.container-tooltip_${i}`).classList.remove('hide-item');
                                    }
                                });
                            }

                            for (let i = 1; i < trList.length; i++) {
                                trList[i].addEventListener('mouseout', e => {
                                    document.querySelector(`.container-tooltip_${i}`).classList.add('hide-item');
                                });
                            }
                        }, 1000);
                    }
                    //customTooltip();

                    let pmvicData = $('#upload_datas').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "scrollCollapse": true,
                        "autoWidth": false,
                        "responsive": true,
                        "order": [],
                        "ajax": {
                            url: "../../../private/controller/upload/process-upload.php",
                            type: "POST"
                        },
                        "columnDefs": [{
                                "targets": "datatable-nosort",
                                "orderable": false,
                            },
                            {
                                className: "hovertooltip",
                                "targets": [8]
                            }
                        ],
                        lengthMenu: [
                            [10, 25, 50, 1000],
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

                    $('#upload_datas').on('draw.dt', function() {
                        customTooltip();
                    });

                    $('#upload_datas_filter input').on('keyup', function() {
                        customTooltip();
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

                                $('#id-upload').val(data.id);

                                //$('#opacity_k').val(JSON.parse(data.OPACITY).Result_K);
                                //$('#emission_co').val(JSON.parse(data.EMISSIONS).Result_CO);
                                //$('#emission_hc').val(JSON.parse(data.EMISSIONS).Result_HC);

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
                        //customTooltip();
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


                                    if (data == 'true') {
                                        poUpRightCorner('success', 'Update Successfully.');
                                        pmvicData.ajax.reload();
                                        $('#re-upload').modal('hide');
                                    } else {
                                        poUpRightCorner('error', 'Someting Went Wrong!!!.');
                                    }

                                },
                                complete: function() {


                                    $('#formPmvicUpdate').trigger("reset");
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
                        //customTooltip();
                    });

                    $(document).on('click', '.upload-deleted', function() {
                        event.preventDefault();

                        let delete_id = $(this).data('id');


                        $.ajax({
                            method: "POST",
                            url: "../../../private/controller/upload/fetch-upload.php",
                            data: {
                                'reupload_id': delete_id
                            },
                            success: function(response) {

                                const data = JSON.parse(response);

                                console.log(data)

                                $('#id-deleted').val(data.id);
                                $('#label-delete').html('<span class="text-center"><h5>Do You Want delete "' + data.TRANSACTION_NO + '"</h5></span>');

                                $('#DeleteReupload').modal('show');

                            },
                            error: function(response) {
                                poUpRightCorner('error', 'Error Seleting Data');
                            }
                        });
                    });

                    
                    $(document).on('click', '#DeleteReupload', function() {
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
                                    pmvicData.ajax.reload();
                                } else {
                                    poUpRightCorner('error', 'Someting Went Wrong!!!.');
                                }

                            },
                            complete: function() {

                                $('#DeleteReupload').modal('hide');
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
                        //customTooltip();
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
                });
            </script>